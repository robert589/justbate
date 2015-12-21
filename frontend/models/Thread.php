<?php

namespace frontend\models;
use yii\db\ActiveRecord;
use common\models\User;
use Yii;
class Thread extends ActiveRecord{

	public static function tableName()
    {
        return 'thread';
    }


    public static function retrieveAll(){
   		return  Self::find()->joinWith('user');    
   	}

   	public  function getUser(){
         return $this->hasOne(User::className(), ['id' => 'user_id']);

    }
}