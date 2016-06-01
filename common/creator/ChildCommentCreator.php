<?php

namespace common\creator;
use common\entity\ChildCommentEntity;
use common\entity\ThreadCommentEntity;
use common\models\ChildComment;


class ChildCommentCreator extends CommentCreator{

    const NEED_COMMENT_INFO  = 1;

    /**
     * ChildCommentCreator constructor.
     * @param ChildCommentCreator $comment_entity
     */
    function __construct(ChildCommentEntity $comment_entity)
    {
        parent::__construct($comment_entity);
    }

    /**
     * @param array $config
     * @return ChildCommentEntity
     */
    public function get(array $needs){

        parent::get($needs);

        foreach($needs as $need){
            switch($need){
                case self::NEED_COMMENT_INFO:
                    $this->getCommentInfo();
                    break;

                default:
                    break;
            }
        }
        return $this->comment;
    }

    public function getCommentInfo(){
        $result  = ChildComment::getComment($this->comment->getCommentId());
        $this->comment->setDataFromArray($result);
    }
}