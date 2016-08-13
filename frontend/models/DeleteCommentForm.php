<?php

namespace frontend\models;

use yii\base\Model;

use common\models\Comment;

class DeleteCommentForm extends Model {
	public $comment_id;
        
        public $user_id;
        
	public function rules() {
		return [
                    [['comment_id', 'user_id'], 'integer'],
                    [['comment_id', 'user_id'], 'required']
                    ];
	}

	public function delete() {
            if($this->validate()) { 
                if($this->isOwner()) {
                    $comment = Comment::findOne(['comment_id' => $this->comment_id]);
                    $comment->comment_status = 0;
                    return $comment->update();   
                }                
            }
            return false;
	}
        
        private function isOwner() {
            return Comment::findOne(['comment_id' => $this->comment_id])->user_id === $this->user_id;
        }        

}

?>