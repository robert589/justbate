<?php
namespace common\models;


use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class NotificationType extends ActiveRecord
{

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