<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class CommentLikes extends ActiveRecord
{
	public function getTable(){
		return 'comment_likes';
	}

	public static function retrieveCommentLike($comment_id){
		$sql ="SELECT  (SELECT count(*) 
						from comment_likes cl 
						where cl.comment_id = $comment_id and cl.comment_likes = 1) as total_like,
						(SELECT count(*)
						from comment_likes cl1
						where cl1.comment_id = $comment_id and cl.comment_likes = 0) as total_dislike,
					comment_id
				from comment_likes
				where comment_id = $comment_id";

	     return  \Yii::$app->db->createCommand($sql)->queryOne();

	}
}