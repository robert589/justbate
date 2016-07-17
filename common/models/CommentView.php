<?php

namespace common\models;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class CommentView extends ActiveRecord{

    public static function tableName()
    {
        return 'comment_view';
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