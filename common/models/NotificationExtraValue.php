<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * NotificationReceiver model
 *
 * @property string $notification_type_name
 * @property string $url_key_value
 * @property string $extra_value
 * @property integer $created_at
 * @property integer $updated_at
 */
class NotificationExtraValue extends ActiveRecord
{

    public static function tableName()
    {
        return 'notification_extra_value';
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