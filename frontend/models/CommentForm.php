<?php
namespace frontend\models;

use common\models\User;
use common\models\Comment;
use common\models\ThreadComment;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class CommentForm extends Model
{
    public $comment;
    public $thread_id;
    public $user_id;
    public $choice_text;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment', 'choice_text'] , 'required'],
            [['thread_id', 'user_id'], 'integer'],
            ['choice_text', 'string'],
            ['comment', 'string']

       ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function store()
    {
        if ($this->validate()) {

            $comment = new Comment();
            $comment->comment = $this->comment;
            $comment->user_id = $this->user_id;
            if($comment->save()){
                $thread_comment = new ThreadComment();
                $thread_comment->comment_id = $comment->comment_id;
                $thread_comment->choice_text = $this->choice_text;
                $thread_comment->thread_id = $this->thread_id;
                if($thread_comment->save()){
                    return true;
                }
            }

            return null;
        }

        return null;
    }
}
