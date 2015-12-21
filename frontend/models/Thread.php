<?php

namespace frontend\models;
use yii\db\ActiveRecord;
use yii\db\Query;

use common\models\User;
use Yii;
class Thread extends ActiveRecord{

	public static function tableName()
    {
        return 'thread';
    }


  public static function retrieveAllBySql(){
    return "
Select TU.*, avg(rating) as avg_rating from 
(Select * from thread inner join user where thread.thread_id = user.id ) TU
left join rate  on
 TU.thread_id = rate.thread_id
";
  
  }


  public static function countAll(){
        Yii::trace(\Yii::$app->db->createCommand('SELECT COUNT(*) FROM (Select * from thread inner join user where thread.thread_id = user.id) TU')->queryScalar());
        return 1;

  }

  
  public static function retrieveAll(){
    
         return Self::select('AVG(rate.rating) as rating','*')->innerJoin('user', ['id' => 'user_id'])->innerJoin('rate',['thread_id' =>'thread_id'])->groupBy('rate.thread_id');    

      /*
      return  Self::find()->joinWith('user')
     	->joinWith('rate')
     	->select(['AVG(rate.rating) as rating, thread.*, user.*'])
     	->groupBy('rate.thread_id'); */   
  }

  public  function getUser(){
    	     return $this->hasOne(User::className(), ['id' => 'user_id']);

  }

  public function getRate(){
    	return $this->hasMany(Rate::className(), ['thread_id' =>'thread_id']);
  }
}