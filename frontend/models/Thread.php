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
            ((Select * from thread inner join user where thread.user_id = user.id ) TU
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

      public static function retrieveTop10TrendingTopic(){

        //Retrieve top 10 trending topic which counted from participants
        $sql = "SELECT T.thread_id, TT.participants, title from thread T
    left join
    (SELECT thread_id, COUNT(user_id) as participants
        from (SELECT distinct user_id, thread_id from rate
              union
             SELECT distinct user_id, thread_id from comment where thread_id is not null)  P
        group by thread_id
        order by participants desc
        limit 10 ) TT
        on T.thread_id = TT.thread_id
        limit 10
        ";
        return \Yii::$app->db->createCommand($sql)->queryAll();


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

      public static function retrieveThreadById($thread_id, $user_id){

          if(empty($user_id)){
            $user_id = 0;
          }
          $sql = "Select TU.*,
                        avg(rating) as avg_rating ,
                        (SELECT COUNT(*) from rate where thread_id = :thread_id) as total_raters,
                        (SELECT COUNT(*) from rate where thread_id = :thread_id and user_id = :user_id) as  hasRate,
                        (SELECT COUNT(*) from thread_vote where thread_id = :thread_id and agree  = 1) as total_agree,
                        (SELECT COUNT(*) from thread_vote where thread_id = :thread_id and agree  = -1) as total_disagree,
                        (SELECT agree from thread_vote where thread_id = :thread_id and user_id = :user_id) as current_user_vote
                        from
                         ((Select * from thread inner join user where thread.user_id = user.id ) TU
                          left join rate  on
                          TU.thread_id = rate.thread_id)
                        where TU.thread_id = :thread_id
                          group by(thread_id)";

          $result =  \Yii::$app->db->createCommand($sql)->
                        bindParam(':thread_id', $thread_id)->
                        bindParam(':user_id', $user_id)->
                        queryOne();


          return $result    ;
      }



      public  function getUser(){
                 return $this->hasOne(User::className(), ['id' => 'user_id']);

      }

      public function getRate(){
            return $this->hasMany(Rate::className(), ['thread_id' =>'thread_id']);
      }



    public static function retrieveByUser(){
        $thread = Thread::find();

        $id = '1';

        $dash_thread = $thread->select('title, content, date_created')
                  ->from('thread')
                  ->where(['user_id' => $id]);



        return $dash_thread;

    }


    public static  function getRecentActivityCreateThread($username){
        $sql = "SELECT thread.*
        FROM thread, user
        where thread.user_id = user.id and user.username = '$username'
        order by `date_created` desc";

        $result =  \Yii::$app->db->createCommand($sql)->queryAll();

        return $result;

    }

}