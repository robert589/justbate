<?php

namespace backend\models;

use common\models\ThreadComment;
use yii\base\Model;
use Yii;
use common\models\Comment;

class EditChoiceThreadCommentForm extends Model {

    public $thread_id;
    public $comment_id;
    public $new_choice_text;
    public $old_choice_text;

    public function rules() {
        return [
            [['comment_id', 'thread_id'], 'integer'],
            [['new_choice_text', 'old_choice_text'], 'string'],
            [['comment_id', 'thread_id',
                'new_choice_text', 'old_choice_text'], 'required'],

        ];
    }

    public function update() {
        if($this->validate()) {

            $thread_comment = ThreadComment::findOne(['comment_id' => $this->comment_id,
                                                    'thread_id' => $this->thread_id]);

            if($this->new_choice_text != $this->old_choice_text){
                $thread_comment->choice_text = $this->new_choice_text;
                return $thread_comment->update();
            }
            return true;
        }
        else{
        }
        return false;
    }
}

?>
