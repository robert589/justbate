<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

class Issue extends ActiveRecord{
    const ID = "issue_id";
    const NAME = "issue_name";
    const DESCRIPTION = "issue_description";
    const TABLE_NAME = "issue";

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_BANNED = 11;

	public static function tableName()
    {
        return self::TABLE_NAME;
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


    /**
     * Status: Terminated (it is replaced by followed issue)-
     * To get popular issue
     */
    public static function getPopularIssue(){
        $sql = "SELECT issue.issue_name , count(thread_issue.thread_id) as total_thread
                from issue,thread_issue
                where issue.issue_name = thread_issue.issue_name
                group by(thread_issue.issue_name)
                order by total_thread desc
                limit 8";

        $results =  Yii::$app->db->createCommand($sql)->
                    queryAll();

        $mapped_issue_list = array();
        foreach($results as $result){
            $mapped_issue['label'] = $result['issue_name'];
            $mapped_issue['url']  = Yii::$app->request->baseUrl . '/issue/' . $result['issue_name'] ;
            $mapped_issue_list[] = $mapped_issue;
        }


        return $mapped_issue_list;

    }

    public static function checkExist($issue){
        return self::find()->where(['issue_name' => $issue])->exists();
    }

    public static function getIssueBySearch($q, $except, $user_id = null){
        $q = '%' . $q . '%';

        $sql = "Select issue_name as id, issue_name as text from issue where issue_name like :query";

        if($except === true){
            $sql .= " and issue_name NOT IN(Select issue_name from user_followed_issue where user_id = :user_id )";

            return
                \Yii::$app->db
                    ->createCommand($sql)
                    ->bindParam(':query', $q)
                    ->bindParam(':user_id', $user_id)
                    ->queryAll();
        }
        else{
            return \Yii::$app->db
                ->createCommand($sql)
                ->bindParam(':query', $q)
                ->queryAll();
        }

    }

}