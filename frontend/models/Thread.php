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

  public static function retrieveSqlByTopic($topic_name){
     return "
        Select TU.*, avg(rating) as avg_rating from 
        ((Select * from thread inner join user where thread.thread_id = user.id ) TU
        left join rate  on
        TU.thread_id = rate.thread_id)
        where topic_name = \"$topic_name\"
        group by(thread_id)
    ";
  }


  

  public static function countAll(){
        $command =  \Yii::$app->db->createCommand('SELECT COUNT(*) FROM (Select * from thread inner join user on thread.user_id = user.id) TU')->queryScalar();
        return (int)($command);
        

  }


  public static function countByTopic($topic_name){
       $command =  \Yii::$app->db->createCommand("SELECT COUNT(*) FROM (Select * from thread inner join user on thread.user_id = user.id where topic_name = \"$topic_name\") TU")->queryScalar();
        return (int)($command);
  }
  
  public static function retrieveAll(){
    
         return Self::find()->all();
     
  }

  public static function retrieveThreadById($id, $user_id){

      if(empty($user_id)){
        $user_id = 0;
      }
      $sql = "Select TU.*, 
                    avg(rating) as avg_rating ,
                    (SELECT COUNT(*) from rate where thread_id = $id) as total_voters,
                    (SELECT COUNT(*) from rate where thread_id = $id and user_id = $user_id) as
          hasVote
              from 
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