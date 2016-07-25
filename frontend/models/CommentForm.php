<?php
namespace frontend\models;

use common\models\User;
use common\models\Comment;
use common\models\ThreadComment;
use yii\base\Model;
use frontend\dao\CommentDao;
use Yii;

/**
 * Signup form
 */
class CommentForm extends Model
{
    public $comment;
    public $thread_id;
    public $user_id;
       
    
    private $comment_dao;
    
    
    public function init() {
        $this->comment_dao = new CommentDao();
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment'] , 'required'],
            [['thread_id', 'user_id'], 'integer'],
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
        if (!$this->validate()) {
            return null;
        }       
        
        if(($comment_id = $this->getExistingCommentId()) !== null) {
            return $this->createNewComment();
        } else {
            return $this->updateComment($comment_id);
        }     

    }
    
    private function updateComment($comment_id) {
        $comment = Comment::find()->where(['comment_id' => $comment_id])->one();
        $comment->comment = $this->comment;
        return $comment->update();
    }
    
    private function createNewComment() {
        $comment = new Comment();
        $comment->comment = $this->comment;
        $comment->user_id = $this->user_id;
        
        if($comment->save()){
            $thread_comment = new ThreadComment();
            $thread_comment->comment_id = $comment->comment_id;
            $thread_comment->thread_id = $this->thread_id;
            if($thread_comment->save()){
                return $thread_comment->comment_id;
            }
        }
        
        return null;

    }
    
    private function getExistingCommentId() {
        return $this->comment_dao->getExistingCommentId($this->thread_id, $this->user_id);
    }
    
     
}
