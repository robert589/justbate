<?php
namespace common\models;


use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class NotificationType extends ActiveRecord
{

    const THREAD_TYPE = 'thread';

    public static function tableName()
    {
        return 'notification_type';
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
}