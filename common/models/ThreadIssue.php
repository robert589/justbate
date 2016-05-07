<?php

namespace common\models;
use yii\db\ActiveRecord;
use yii\db\Query;
use Yii;
class ThreadIssue extends ActiveRecord{

    public static function tableName()
    {
        return 'thread_issue';
    }

    public static function getIssue($thread_id){
        $sql = "
            SELECT issue_name
            from thread_issue
            where thread_issue.thread_id = :thread_id
        ";

        return  \Yii::$app->db->createCommand($sql)->
        bindParam(':thread_id', $thread_id)->
        queryAll();

    }
}