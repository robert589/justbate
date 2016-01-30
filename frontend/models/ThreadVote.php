<?php

namespace frontend\models;
use yii\db\ActiveRecord;
use yii\db\Query;
use Yii;


class ThreadVote extends ActiveRecord{
    // $agree, $user_id, $thread_id


    public static function tableName()
    {
        return 'thread_vote';
    }


    public static function getTotalLikeDislikeBelongs($thread_id, $user_id){
        $sql = "SELECT thread_id,
                (SELECT COUNT(*) from thread_vote where thread_id = :thread_id and agree  = 1) as total_agree,
                (SELECT COUNT(*) from thread_vote where thread_id = :thread_id and agree  = -1) as total_disagree,
                (SELECT agree from thread_vote where thread_id = :thread_id and user_id = :user_id) as current_user_vote
                from thread_vote
                where thread_id = :thread_id";


        // DAO
        return \Yii::$app->db
            ->createCommand($sql)
            ->bindValues([':thread_id' => $thread_id])
            ->bindValues([':user_id' => $user_id])
            ->queryOne();
    }

}