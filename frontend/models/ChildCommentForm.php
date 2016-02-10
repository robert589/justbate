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
            [['childComment'] , 'required'],
            [['thread_id','user_id','parent_id'], 'integer']
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
            $comment->comment = $this->childComment;
            $comment->parent_id = $this->parent_id;
            $comment->thread_id = $this->thread_id;
            $comment->user_id = \Yii::$app->user->getId();

            if($comment->save()){
                return true;
            }

            return null;
        }

        return null;
    }
}