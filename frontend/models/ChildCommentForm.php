<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class ChildCommentForm extends Model
{
    public $childComment;
    public $thread_id;
    public $user_id;
    public $parent_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['childComment', 'thread_id', 'parent_id'] , 'required'],
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
