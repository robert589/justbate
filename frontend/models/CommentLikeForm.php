<?php
namespace frontend\models;

use frontend\models\CommentLikes;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class CommentLikeForm extends Model
{
    public $comment_id;
    public $comment_likes;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment_likes', 'comment_id'] , 'required'],
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

            $comment = new CommentLikes();
            $comment->comment_id = $this->comment_id;
            $comment->comment_likes = $this->comment_likes;
            $comment->user_id = \Yii::$app->user->getId();

            if($comment->save()){
                return true;
            }

            return null;
        }

        return null;
    }
}
