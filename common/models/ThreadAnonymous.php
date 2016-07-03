<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class ThreadAnonymous
 * @package common\models
 * @property int $thread_id
 * @property int $user_id
 * @property int $anonymous_id
 */
class ThreadAnonymous extends ActiveRecord
{
    public static function getTable(){
        return 'thread_anonymous';
    }

}