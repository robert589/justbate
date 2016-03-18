<?php

namespace common\models;

use yii\db\ActiveRecord;

class ThreadComment extends ActiveRecord
{
    public static function getTable(){
        return 'thread_comment';
    }

    public static function getAllThreadComments(){
        $sql = "SELECT * from thread_comment inner join comment on
            thread_comment.comment_id = comment.comment_id
            ";
        return  \Yii::$app->db->createCommand($sql)->queryAll();
    }

    public static function getComment($comment_id){
        $sql = "SELECT * from thread_comment inner join comment on thread_comment.comment_id = comment.comment_id
                where thread_comment.comment_id = :comment_id";

        return  \Yii::$app->db->createCommand($sql)->bindParam(':comment_id', $comment_id)->queryOne();

    }

    public static function getThreadCommentsByUserId($user_id){
        $sql = "SELECT *
                from thread_comment, comment, thread
                where comment.user_id = :user_id and comment.comment_id = thread_comment.comment_id and thread.thread_id  =thread_comment.thread_id";

        return  \Yii::$app->db->createCommand($sql)->bindParam(':user_id', $user_id)->queryAll();

    }


}