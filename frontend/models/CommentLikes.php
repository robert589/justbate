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
						where cl.comment_id = $comment_id and comment_likes = 1) as total_like,
						(SELECT count(*)
						from comment_likes cl1
						where cl1.comment_id = $comment_id and comment_likes = 0) as total_dislike,
					comment_id
				from comment_likes
				where comment_id = $comment_id";

	     return  \Yii::$app->db->createCommand($sql)->queryOne();

	}

	public static function checkExistence($comment_id, $user_id){
		return Self::find()
				->where(['comment_id' => $comment_id, 'user_id' => $user_id])
				->exists();
	}

	public static function updateExistence($comment){
		$comment_like = Self::findOne(['comment_id' => $comment->comment_id,'user_id'=> $comment->user_id]);

		$comment_like->comment_likes = $comment->comment_likes;	

		return ($comment_like->update() !== false);
	}

	public static function getRecentCommentLikes($username){
		$sql = "select *
				from comment_likes, user
				where user.id = comment_likes.user_id and user.username= :username
				order by date_created desc";
		// DAO
		return \Yii::$app->db
			->createCommand($sql)
			->bindValues([':username' => $username])
			->queryAll();
	}
}