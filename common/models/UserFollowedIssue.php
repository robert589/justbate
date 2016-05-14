<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User Email Authentication model
 *
 * @property integer $user_id
 * @property integer $issue_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $validated
 */
class UserFollowedIssue extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_followed_issue}}';
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

    public static function getFollowedIssue($user_id){
        $sql = "SELECT issue_name from user_followed_issue where user_id = :user_id";

        $results =  Yii::$app->db->createCommand($sql)->
        bindParam(":user_id", $user_id)->
        queryAll();

        $mapped_issue_list = array();
        foreach($results as $result){
            $mapped_issue['label'] = $result['issue_name'];
            $mapped_issue['url']  = Yii::$app->request->baseUrl . '/issue/' . $result['issue_name'] ;
            $mapped_issue['template'] = '<a href="{url}" data-pjax="0">{icon}{label}</a>';
            $mapped_issue_list[] = $mapped_issue;
        }


        return $mapped_issue_list;
    }

    public static function isFollower($user_id, $issue_name){
        return UserFollowedIssue::find()->where(['user_id' => $user_id, 'issue_name' => $issue_name])->exists();
    }


    public static function getTotalFollowedIssue($issue_name){

        $sql = "SELECT count(*) from user_followed_issue where issue_name = :issue_name";

        return (int) Yii::$app->db->createCommand($sql)->
                bindParam(":issue_name", $issue_name)->
                queryScalar();
    }



}
