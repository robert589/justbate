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




}