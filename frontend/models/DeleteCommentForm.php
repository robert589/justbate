<?php

namespace frontend\models;

use yii\base\Model;

use common\models\Comment;

class DeleteCommentForm extends Model {
	public $comment_id;

	public function rules() {
		return [['comment_id', 'integer'],
			[['comment_id'], 'required']];
	}

	public function delete() {
		if($this->validate()) {
			$comment = Comment::findOne(['comment_id' => $this->comment_id]);
			$comment->comment_status = 0;
			return $comment->update();
		}
	}


}

?>