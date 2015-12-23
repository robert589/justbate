<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class CommentForm extends Model
{
    public $comment;
    public $thread_id;
    public $yes_or_no;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment', 'yes_or_no', 'thread_id'] , 'required'],
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
            $comment->thread_id = $this->thread_id;
            $comment->yes_or_no = $this->yes_or_no;
            $comment->user_id = \Yii::$app->user->getId();

            if($comment->save()){
                return true;
            }

            return null;
        }

        return null;
    }
}
