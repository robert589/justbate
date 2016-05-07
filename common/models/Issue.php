<?php

namespace common\models;
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


    public static function getIssueList($q){
        $sql = "SELECT issue_id as id, issue_name as text
                   from issue
                   where issue_name like concat('%', :q,'%')
                   limit 10";

        return Yii::$app->db->createCommand($sql)->
        bindParam(":q", $q)->
        queryAll();
    }

    /**
     * Status: Terminated (it is replaced by followed issue)-
     * To get popular issue
     */
    public static function getPopularCategory(){
        $sql = "SELECT issue_name
                from issue
                ";

        return Yii::$app->db->createCommand($sql)->
        queryAll();

    }

    public static function checkExist($issue){
        return Self::find()->where([self::ID => $issue])->exists();
    }

}