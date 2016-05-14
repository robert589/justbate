<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Query;
use Yii;


class ThreadVote extends ActiveRecord{
    // $agree, $user_id, $thread_id

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function tableName()
    {
        return 'thread_vote';
    }


    public static function getUserVote($thread_id, $user_id){
        return self::find()->where(['thread_id' => $thread_id, 'user_id' => $user_id])->one()['choice_text'];
    }

}