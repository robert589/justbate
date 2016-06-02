<?php

namespace backend\models;

use common\models\Comment;
use yii\base\Model;

use common\models\Thread;

class BanCommentForm extends Model {

    public $comment_id;

    public function rules() {
        return [
            [['comment_id'], 'integer'],
            ['comment_id', 'required']
        ];
    }

    public function update() {
        if($this->validate()) {
            $comment  = Comment::findOne(['comment_id' => $this->comment_id]);
            $comment->comment_status = Comment::STATUS_BANNED;
            if($comment->update()){
                return true;
            }
            else{
                return false;
            }
        }
        return true;
    }
}

?>
