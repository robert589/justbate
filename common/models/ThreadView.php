<?php
namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class ThreadView extends ActiveRecord{

    public static function tableName()
    {
        return 'thread_view';
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
