<?php

namespace frontend\models;
use yii\db\ActiveRecord;
use Yii;
class Thread extends ActiveRecord{

	public static function tableName()
    {
        return 'thread';
    }


    public static function retrieveAll(){
    	return Self::find()->all();
    }

}