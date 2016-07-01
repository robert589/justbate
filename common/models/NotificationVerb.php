<?php
namespace common\models;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class NotificationVerb extends ActiveRecord
{

    const PEOPLE_COMMENT_ON_YOUR_THREAD = 'people_comment';

    const PEOPLE_VOTE_ON_YOUR_THREAD = 'people_vote';

    const PEOPLE_COMMENT_ON_YOUR_COMMENT = 'people_comment';

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