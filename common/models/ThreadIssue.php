<?php

namespace common\models;
use yii\db\ActiveRecord;
use yii\db\Query;
use Yii;
class ThreadIssue extends ActiveRecord{
    public static function tableName()
    {
        return 'thread_issue';
    }
}