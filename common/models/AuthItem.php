<?php

namespace common\models;

use yii\db\ActiveRecord;

class AuthItem extends ActiveRecord
{
    public function getTable(){
        return 'auth_item';

    }

}