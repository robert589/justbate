<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * NotificationActor model
 *
 * @property integer $notification_id
 * @property integer $actor_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class NotificationActor extends ActiveRecord
{

    public static function tableName()
    {
        return 'notification_actor';
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