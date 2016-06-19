<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * NotificationReceiver model
 *
 * @property integer $notification_id
 * @property integer $receiver_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class NotificationReceiver extends ActiveRecord
{

    public static function tableName()
    {
        return 'notification_receiver';
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