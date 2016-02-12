<?php

namespace common\models;

use yii\db\ActiveRecord;

class ThreadComment extends ActiveRecord
{
    public static function getTable(){
        return 'thread_comment';
    }




}