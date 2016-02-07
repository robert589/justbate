<?php

namespace common\models;

use yii\db\ActiveRecord;

class Comment extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public function getTable(){
		return 'comment';
	}

	public static function retrieveSqlComment($thread_id, $yes){


		return "SELECT  TUC.*, (SELECT count(*) 
				                from comment_likes CL 
				                where CL.comment_id =TUC.comlikeid and CL.comment_likes  = 1 ) as total_like,
								(SELECT count(*) 
				                 from comment_likes CL 
				                 where CL.comment_id =TUC.comlikeid and CL.comment_likes  = -1 ) as total_dislike,
                            (SELECT CL1.comment_likes
                                from comment_likes CL1
                             	where CL1.comment_id = TUC.comlikeid and CL1.user_id = TUC.comlikeuser ) as vote
                                
                            
				from (Select *
				     from (Select comment_likes.comment_id as comlikeid,
				      	     	  comment_likes.user_id as comlikeuser,
				      	     	  comment_likes.comment_likes, 
            					  comment.* 
                           from comment 
                           left join comment_likes 
                           on comment_likes.comment_id = comment.comment_id) TU 
                     inner join user on user.id = TU.user_id) TUC 
                where thread_id = $thread_id and yes_or_no = $yes
                group by(TUC.comment_id)
               ";
	}



	public static function countComment($thread_id, $yes){
		$sql = "
        SELECT COUNT(*) 
          FROM (SELECT *
              from comment inner join user on user.id = comment.user_id
              where thread_id = :thread_id and yes_or_no  = :yes) TU
      	";

        $command =  \Yii::$app->db->createCommand($sql)
                    ->bindParam(':thread_id', $thread_id)
                    ->bindParam(":yes", $yes)
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
}