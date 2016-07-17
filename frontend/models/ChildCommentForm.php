<?php
namespace frontend\models;
use common\models\Comment;
use yii\base\Model;
use common\models\ChildComment;


/**
 * Signup form
 */
class ChildCommentForm extends Model
{
    public $child_comment;
    public $thread_id;
    public $user_id;
    public $parent_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['child_comment'] , 'required'],
            [['thread_id','user_id','parent_id'], 'integer']
        ];
    }

    /**
     * @return int|null
     */
    public function store()
    {
        if ($this->validate()) {
            $comment = new Comment();
            $comment->user_id = $this->user_id;
            $comment->comment = $this->child_comment;
            if($comment->save()){
                $child_comment = new ChildComment();
                $child_comment->comment_id = $comment->comment_id;
                $child_comment->parent_id = $this->parent_id;
                if($child_comment->save()){
                    return $comment->comment_id;
                }
            }
            return null;
        }

        return null;
    }
}