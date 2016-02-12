<?php
namespace frontend\models;

use common\models\CommentVote;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class CommentVoteForm extends Model
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

            if($this->checkExist()){
                return $this->updateVote();
            }
            else{
               return $this->createVote();
            }

        }

        return null;
    }

    private function checkExist(){
        return CommentVote::find()->where(['user_id' => $this->user_id, 'comment_id' => $this->comment_id])->exists();
    }

    private function updateVote(){
        $comment_votes = CommentVote::findOne(['user_id' => $this->user_id, 'comment_id' => $this->comment_id]);

        if($comment_votes->vote != $this->vote){
            $comment_votes->vote = $this->vote;
            if( $comment_votes->update()){

                return true;
            }
            else{
                return false;
            }
        }

        return true;

    }

    private function createVote(){
        $comment_votes = new CommentVote();
        $comment_votes->user_id = $this->user_id;
        $comment_votes->vote = $this->vote;
        $comment_votes->comment_id = $this->comment_id;

        if($comment_votes->save()){
            return true;
        }
        else{
            return false;
        }
    }
}
