<?php 

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord{
	
}

public  function getUser(){
    return $this->hasOne(User::className(), ['id' => 'user_id']);
  }