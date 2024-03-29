<?php

namespace common\models;

use yii\db\ActiveRecord;

class ChildComment extends ActiveRecord
{
    public function getTable(){
        return 'child_comment';

    }

    public static function getAllChildCommentsByCommentId($thread_comment_id   ){
        $sql = "SELECT *
                from child_comment
                inner join comment
                on child_comment.comment_id = comment.comment_id
                inner join user
                on user.id = comment.user_id
                where parent_id = :thread_comment_id
                order by comment.created_at desc";

            $result =  \Yii::$app->db->createCommand($sql)->
        bindParam(':thread_comment_id', $thread_comment_id)->queryAll();

        return $result;
    }

    public static function getAllChildComments(){
        $sql = "SELECT *
                from child_comment, comment, user
                where child_comment.comment_id = comment.comment_id
                  and user.id = comment.user_id";

        $result =  \Yii::$app->db->createCommand($sql)->
        queryAll();

        return $result;
    }

    public static function getComment($comment_id){
        $sql = "SELECT * from child_comment, comment, user
                where child_comment.comment_id = comment.comment_id
                and child_comment.comment_id = :comment_id
                and user.id = comment.user_id";

        return  \Yii::$app->db->createCommand($sql)->bindParam(':comment_id', $comment_id)->queryOne();

    }


}