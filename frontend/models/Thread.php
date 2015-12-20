<?php

namespace frontend\models;
use yii\db\ActiveRecord;
use Yii;

use common\models\User;

class Thread extends ActiveRecord{

	public static function tableName()
    {
        return 'thread';
    }


    public static function retrieveAll(){

    	return  Self::find()->
    	joinWith('user');
		

    }


    public  function getUser(){
    	      return $this->hasOne(User::className(), ['id' => 'user_id']);

    }
}