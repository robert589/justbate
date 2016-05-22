<?php

namespace common\creator;
use common\entity\ChildCommentEntity;
use common\entity\ThreadCommentEntity;
use common\models\ChildComment;


class ChildCommentCreator extends CommentCreator{


    /**
     * ChildCommentCreator constructor.
     * @param ChildCommentCreator $comment_entity
     */
    function __construct(ChildCommentEntity $comment_entity)
    {
        parent::__construct($comment_entity);

    }



}