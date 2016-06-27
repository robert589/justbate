<?php
namespace frontend\service;

use frontend\dao\CommentDao;
use frontend\dao\ListNotificationDao;
use frontend\vo\ChildCommentVoBuilder;
use frontend\vo\ThreadCommentVoBuilder;

class CommentService{

    private $comment_dao;

    function __construct(CommentDao $comment_dao)
    {
        $this->comment_dao = $comment_dao;
    }

    public function getCommentInfo($user_id, $thread_id, $comment_id, $child) {
        if($child){
            $builder = new ChildCommentVoBuilder();
            $this->comment_dao->buildChildComment($user_id, $thread_id, $comment_id, $builder);
        }
        else{
            $builder = new ThreadCommentVoBuilder();
            $this->comment_dao->buildThreadComment($user_id, $thread_id, $comment_id, $builder);
        }
        return $builder->build();
    }


}