<?php

namespace frontend\models;
use yii\db\ActiveRecord;


class TagInThread extends ActiveRecord{

    public static function tableName()
    {
        return 'tag_in_thread';
    }


}