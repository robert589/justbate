<?php

namespace frontend\models;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\method\ActiveQuery;

use common\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use Yii;

class Thread extends ActiveRecord{

	public static function tableName()
    {
        return 'thread';
    }


  public static function retrieveAllBySql(){
    return "
        Select TU.*, avg(rating) as avg_rating from 
        ((Select * from thread inner join user where thread.thread_id = user.id ) TU
        left join rate  on
        TU.thread_id = rate.thread_id)
        group by(thread_id)
    ";
  }


  public static function retrieveFilterBySql($filterArray){
      $sql = "
        Select TU.*, avg(rating) as avg_rating from 
        ((Select * from thread inner join user where thread.thread_id = user.id ) TU
        left join rate  on
        TU.thread_id = rate.thread_id)
    ";

      $sql .= " WHERE ";

      $first = 1;
      for($i = 0 ; $i < count($filterArray) ; $i++){
        if($first == 1){
          $first = 0 ;
        }
        else{
          $sql .= " or ";
        }

        $sql .= " TU.topic_id = $filterArray[$i] ";
      }

      $sql .= "group by(thread_id)";

      return $sql;

  }

  public static function countAll(){
        $command =  \Yii::$app->db->createCommand('SELECT COUNT(*) FROM (Select * from thread inner join user on thread.user_id = user.id) TU')->queryScalar();
        return (int)($command);
        

  }

  public static function countFilter($filterArray){

      $sql = "
        SELECT COUNT(*) 
          FROM (Select * 
                from thread 
                inner join user 
                on thread.user_id = user.id WHERE
      ";
      $first = 1;



      for($i = 0; $i < count($filterArray); $i++){
          if($first){
            $first= 0;
          }
          else{
            Yii::$app->end();
            $sql .= " or ";
          }
          $sql .= " thread.topic_id = $filterArray[$i]";
      }
     
      
      $sql .= ") TU ";
      $command =  \Yii::$app->db->createCommand($sql)->queryScalar();
      if($command == 2){
        Yii::$app->end($command);
      }
      return (int)($command);


  }

  
  public static function retrieveAll(){
    
         return Self::find()->all();
     
  }

  public static function retrieveThreadById($id){

      $sql = "Select TU.*, avg(rating) as avg_rating from 
        ((Select * from thread inner join user where thread.thread_id = user.id ) TU
        left join rate  on
        TU.thread_id = rate.thread_id)
        where TU.thread_id = $id
        group by(thread_id)";

      $result =  \Yii::$app->db->createCommand($sql)->queryOne();


      return $result;
  }

  

  public  function getUser(){
    	     return $this->hasOne(User::className(), ['id' => 'user_id']);

  }

  public function getRate(){
    	return $this->hasMany(Rate::className(), ['thread_id' =>'thread_id']);
  }

   public static function getThreadID(){
      return $this->thread_id;
    }

public function behaviors()
{
    return [
        [
            'class' => TimestampBehavior::className(),
            'createdAtAttribute' => 'date_created',
            'updatedAtAttribute' => 'last_edited',
            'value' => new Expression('NOW()'),
        ],
    ];
}

public static function retrieveByUser(){
    $thread = Thread::find();

    $id = '1';

    $dash_thread = $thread->select('title, content, date_created')
              ->from('thread')
              ->where(['user_id' => $id]);



    return $dash_thread;

  }


}