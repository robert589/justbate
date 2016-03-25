<?php

namespace backend\models;

use yii\base\Model;

use common\models\Comment;

class EditCommentForm extends ModeL {

    public $comment_id;
    public $comment;

    public function rules() {
        return [
            [['comment_id'], 'integer'],
            [['comment'], 'string'],
            [['comment_id', 'comment'], 'required'],

        ];
    }

    public function update() {
        if($this->validate()) {

            $comment = Comment::findOne(['comment_id' => $this->comment_id]);
            $comment->comment = $this->comment;
            $comment->update();

            return true;
        }
        return false;
    }
}

?>