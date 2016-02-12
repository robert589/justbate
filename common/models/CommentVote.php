<?php

namespace common\models;

use yii\db\ActiveRecord;

class CommentVote extends ActiveRecord
{
	public function getTable(){
		return 'comment_vote';
	}

	public static function getCommentVotesOfComment($comment_id, $user_id){
		$sql = "SELECT (SELECT COALESCE (count(*),0) from comment_vote where comment_id = :comment_id and vote = 1) as total_like,
				(SELECT COALESCE (count(*),0) from comment_vote where comment_id = :comment_id and vote = -1) as total_dislike,
				vote
				from comment_vote
				where comment_id = :comment_id and user_id = :user_id";

		$result =  \Yii::$app->db->createCommand($sql)->
		bindParam(':comment_id', $comment_id)->
		bindParam(':user_id', $user_id)->
		queryOne();


		return $result    ;


	}

}