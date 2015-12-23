<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class Comment extends ActiveRecord
{
	public function getTable(){
		return 'comment';
	}

	public static function retrieveSqlComment($thread_id, $yes){
		return "SELECT  TUC.*, (SELECT count(*) 
				                from comment_likes CL 
				                where CL.comment_id =TUC.comlikeid and CL.comment_likes  = 1 ) as total_like,
								(SELECT count(*) 
				                 from comment_likes CL 
				                 where CL.comment_id =TUC.comlikeid and CL.comment_likes  = 0 ) as total_dislike
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
          FROM (SELECT * from comment inner join user on user.id = comment.user_id where thread_id = $thread_id and yes_or_no  = $yes) TU
      	";

        $command =  \Yii::$app->db->createCommand($sql)->queryScalar();
      
        return (int)($command);

	}
}