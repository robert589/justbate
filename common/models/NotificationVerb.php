<?php
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class NotificationVerb extends ActiveRecord
{

    public static function tableName()
    {
        return 'notification_verb';
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