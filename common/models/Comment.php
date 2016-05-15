<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\data\SqlDataProvider;
use yii\db\ActiveRecord;
use yii\data\ArrayDataProvider;

class Comment extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_BANNED = 11;

    public function getTable(){
		return 'comment';
	}


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * WEAKNESS: THE total_like, total_dislike, and vote is not working, it causes us need to put it into two queries
     * PERFORMANCE PROBLEM
     * @return string
     */
	public static function getCommentByChoiceText($thread_id, $choice_text, $user_id ){

    
                $sql=  "SELECT comments.*,
                                COALESCE (count(case comment_vote.user_id when :user_id then vote else null end), 0 ) as vote,
                                COALESCE (count(case vote when 1 then 1 else null end),0)as total_like,
                                COALESCE (count(case vote when -1 then 1 else null end),0) as total_dislike
                        FROM (
                            SELECT  comment.* , thread_comment.choice_text , thread_comment.thread_id, user.first_name, user.last_name, user.username, user.photo_path
                            from thread_comment,comment, user
                            where thread_id = :thread_id and
                            thread_comment.choice_text= :choice_text and
                            thread_comment.comment_id = comment.comment_id 			and user.id = comment.user_id and
                            comment_status = 10
                            ) comments
                        LEFT JOIN comment_vote
                        on comment_vote.comment_id = comments.comment_id
                        group by comments.comment_id
                        order by total_like desc


               ";



                return \Yii::$app->db
                    ->createCommand($sql)
                    ->bindValues([':thread_id' => $thread_id])
                    ->bindValues([':choice_text' => $choice_text] )
                    ->bindValue(':user_id', $user_id)
                    ->queryAll();

	}

    public static function getCommentByCommentId($comment_id){
            $sql=  "Select * ,
                          COALESCE (count(case comment_vote.user_id when 2 then vote else null end), 0 ) as vote,
                          COALESCE (count(case vote when 1 then 1 else null end),0)as total_like,
                          COALESCE (count(case vote when -1 then 1 else null end),0) as total_dislike
                    from(
                        SELECT  comment.* ,
                                thread_comment.thread_id,
                                user.first_name, user.last_name,user.username, user.photo_path
                        from thread_comment, comment, user
                        where thread_comment.comment_id = :comment_id and
                              thread_comment.comment_id = comment.comment_id and
                              user.id = comment.user_id
                        ) comments
                    left join comment_vote
                    on comment_vote.comment_id = comments.comment_id

               ";



        return \Yii::$app->db
            ->createCommand($sql)
            ->bindValues([':comment_id' => $comment_id])
            ->queryOne();
    }

	public static function countComment($thread_id, $choice_text){
		$sql = "
              SELECT COUNT(*)
              FROM (SELECT thread_comment.*
                   from thread_comment
                  inner join comment
                  on thread_comment.comment_id = comment.comment_id
                  where thread_id = :thread_id and thread_comment.choice_text= :choice_text) TU
      	";

        $command =  \Yii::$app->db->createCommand($sql)
                    ->bindParam(':thread_id', $thread_id)
                    ->bindParam(":choice_text", $choice_text)
                    ->queryScalar();
      
        return (int)($command);

	}


  public static function retrieveCommentByUserId($comment_id, $user_id){

      $sql =  "SELECT  TUC.*, 
                (SELECT count(*) 
                        from comment_likes CL 
                        where CL.comment_id =TUC.comlikeid and CL.comment_likes  = 1 ) as total_like,
                (SELECT count(*) 
                         from comment_likes CL
                         where CL.comment_id =TUC.comlikeid and CL.comment_likes  = -1 ) as total_dislike,
               (SELECT CL1.comment_likes
                      from comment_likes CL1
                    where CL1.user_id = $user_id and CL1.comment_id = $comment_id ) as vote
        from (Select *
             from (Select comment_likes.comment_id as comlikeid,
                        comment_likes.user_id as comlikeuser,
                        comment_likes.comment_likes, 
                        comment.* 
                           from comment 
                           left join comment_likes 
                           on comment_likes.comment_id = comment.comment_id) TU 
                     inner join user on user.id = TU.user_id) TUC 
                where TUC.comment_id =$comment_id
               ";

      return   \Yii::$app->db->createCommand($sql)->queryOne();

  }

  public static function retrieveChildComment($comment_id){
  	 $sql = "SELECT * , 
        (SELECT COUNT(*) from comment_likes CL where CL.comment_id = C.comment_id and CL.comment_likes = 1) as total_like,
        (SELECT COUNT(*) from comment_likes CL where CL.comment_id = C.comment_id and CL.comment_likes = -1) as total_dislike,
        (SELECT CL1.comment_likes
                                from comment_likes CL1
                              where CL1.comment_id = C.comment_id and CL1.user_id = C.user_id ) as vote

        FROM (SELECT * from comment inner join user on comment.user_id = user.id) C 

        WHERE parent_id = $comment_id
";

  	return $sql;
  }

  public static function countChildComment($comment_id){
  	$sql = "SELECT count(*)
  			from comment 
  			where parent_id = $comment_id";

     $command =  \Yii::$app->db->createCommand($sql)->queryScalar();

    return (int)($command);
	
  }

  public static function getComment($comment_id){
      $sql = "SELECT comment
            from comment
            where comment_id = $comment_id";
      return  \Yii::$app->db->createCommand($sql)->queryOne()['comment'];

  }

    public static function getRecentCommentActivity($username){
       $sql = "SELECT user1.*, comment.*, thread.* , user2.first_name as parent_first_name , user2.last_name as parent_last_name         from comment, user user1, thread, user user2
                where comment.user_id = user1.id and user1.username = :username and comment.thread_id = thread.thread_id and comment.parent_id = user2.id

                order by comment.date_created desc";
        // DAO
        return \Yii::$app->db
            ->createCommand($sql)
            ->bindValues([':username' => $username])
            ->queryAll();
    }


    public static function getAllCommentProviders($thread_id, $thread_choices, $user_id = 0){

        //the prev $thread_choice is an associative array, convert to normal array
        //the prev $thread_chocie: e.g  ("agree" : "agree ( 0 voters), " disagree": "disagree (1 voters) " )

        //initialize array
        $all_providers = array();
        $limit = 5;
        foreach($thread_choices as $thread_choice){
            //$thread_choice contains the choice of the thread, e.g = "Agree", "Disagree"
            $allModels = self::getCommentByChoiceText($thread_id, $thread_choice['choice_text'], $user_id);
            $dataProvider =new ArrayDataProvider([
                'allModels' => $allModels,
                'pagination' => [
                    'pageSize' =>$limit,

                ],

            ]);
            $all_providers[$thread_choice[  'choice_text'] . ' (' . count($allModels) . ')' ] = $dataProvider;
        }

        return $all_providers;
    }

    public static function checkNewChildComment($comment_id, $latest_time){
        return self::find()->where(['child_comment.comment_id = comment.comment_id'])
                    ->andWhere(["child_comment.parent_id = $comment_id"])
                    ->andWhere(["comment.created_at < $latest_time"])->exists();
    }

    public static function getLatestChildComment($comment_id, $latest_time){

    }
}