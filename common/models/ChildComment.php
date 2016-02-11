<?php

namespace common\models;

use yii\db\ActiveRecord;

class ChildComment extends ActiveRecord
{
    public function getTable(){
        return 'child_comment';

    }

    public static function getAllChildComments($thread_comment_id){
        $sql = "SELECT *
                from child_comment
                inner join comment
                on child_comment.comment_id = comment.comment_id
                inner join user
                on user.id = comment.user_id
                where parent_id = :thread_comment_id";

        $result =  \Yii::$app->db->createCommand($sql)->
        bindParam(':thread_comment_id', $thread_comment_id)->
        queryAll();

        return $result;
    }

}