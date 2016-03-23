<?php

namespace common\models;

use yii\db\ActiveRecord;

class ThreadComment extends ActiveRecord
{
    public static function getTable(){
        return 'thread_comment';
    }

    /**
     * Although it seems better to put everything in a single big chunk query together
     * with Thread::getThread(), i decided to split it for the sake of readability
     * @param $thread_id
     *
     */
    public static function getBestCommentFromThread($thread_id){
        $sql = "SELECT * from thread_comment,comment, user
where thread_comment.thread_id = :thread_id and thread_comment.comment_id = comment.comment_id
	and comment.user_id = user.id limit 1";

        return  \Yii::$app->db->createCommand($sql)
                ->bindParam(':thread_id', $thread_id)->queryOne();

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

    public static function getTotalThreadComments($thread_id){
        $sql = "SELECT count(*) from thread_comment where thread_id = :thread_id";

        return  (int) \Yii::$app->db->createCommand($sql)->bindParam(':thread_id', $thread_id)->queryScalar();

    }

}