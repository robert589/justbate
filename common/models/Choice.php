<?php

namespace common\models;

use yii\db\ActiveRecord;

class Choice extends ActiveRecord
{
    public function getTable(){
        return 'choice';
    }


}