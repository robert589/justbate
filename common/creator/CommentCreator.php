<?php

namespace common\creator;
use common\entity\ChildCommentEntity;
use common\entity\CommentEntity;
use common\entity\ThreadCommentEntity;
use common\entity\ThreadEntity;
use yii\base\Exception;


abstract class CommentCreator{

    const NEED_COMMENT_VOTE  = 100;


    /**
     * @var CommentEntity | ThreadCommentEntity | ChildCommentEntity
     */
    public $comment;

    /**
     * CommentCreator constructor.
     * @param CommentCreator $comment_entity
     */
    function __construct(CommentEntity $comment_entity)
    {
        $this->comment = $comment_entity;

        //checking whether the model can be used
        $this->validateModel();
    }

    /**
     * @param array $config
     * @return ThreadEntity
     */
    public function get(array $needs){
        foreach($needs as $need){
            switch($need){
                case self::NEED_COMMENT_VOTE:
                    $this->getCommentVote();
                    break;

                default:
                    break;
            }
        }
        return $this->comment;
    }

    /**
     *
     */
    protected function getCommentVote(){
        $comment_vote_comment = \common\models\CommentVote::getCommentVotesOfComment($this->comment->getCommentId(),
            $this->comment->getCurrentUserLoginId());

        $this->comment->setTotalDislike($comment_vote_comment['total_dislike']);

        $this->comment->setTotalLike($comment_vote_comment['total_like']);
        $this->comment->setCurrentUserVote($comment_vote_comment['vote']);

    }

    protected function validateModel(){
        //id must not empty
        if(is_nan($this->comment->getCommentId())){
            throw new Exception("Comment id must not be empty");
        }

    }

}