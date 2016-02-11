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
    public $user_id;
    public $comment_id;
    public $vote;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vote', 'comment_id'] , 'required'],
            ['user_id', 'integer']
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

            if(!CommentLikes::checkExistence($this->comment_id, $comment->user_id)){
                if($comment->save()){
                    return true;
                 }
                return null;

             }
             else{
                return CommentLikes::updateExistence($comment);
             }

        }

        return null;
    }
}
