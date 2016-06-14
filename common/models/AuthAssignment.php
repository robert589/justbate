<?php

namespace common\models;

use yii\db\ActiveRecord;

class AuthAssignment extends ActiveRecord
{
    public function getTable(){
        return 'auth_assignment';

    }

}