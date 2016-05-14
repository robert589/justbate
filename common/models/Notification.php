<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


class Notification extends ActiveRecord{

    public static function tableName()
    {
        return 'notification';
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


    public static function getAllNotifications($user_id){
        $sql = "select description from notification where user_id = :user_id ";

        // DAO
        return \Yii::$app->db
            ->createCommand($sql)
            ->bindValues([':user_id' => $user_id])
            ->queryAll();
    }
}