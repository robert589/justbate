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

    public function getThreadCommentInfo($user_id, $thread_id, $comment_id) {
        $builder = new ThreadCommentVoBuilder();
        $builder = $this->comment_dao->buildThreadComment($user_id, $thread_id, $comment_id, $builder);
        if($builder === null){
            return null;
        }
        else{
            return $builder->build();
        }
    }

    public function getChildCommentInfo($user_id, $comment_id){
        $builder = new ChildCommentVoBuilder();
        $this->comment_dao->buildChildComment($user_id, $comment_id, $builder);

        if($builder === null){
            return null;
        }
        else{
            return $builder->build();
        }

    }

    public function getChildCommentList($user_id, $comment_id, $thread_id) {
        $builder = new ThreadCommentVoBuilder();
        $builder->setCommentId($comment_id);
        $this->comment_dao->buildChildCommentList($comment_id, $user_id, $builder);

        return $builder->build();


    }

    /**
     * From ajax request
     * @param $user_id
     * @param $comment_id
     * @param $thread_id
     * @param $perPage
     * @param $pageSize
     */
    public function getNewChildCommentList($comment_id, $user_id, $last_time, $limit) {
        $child_comment_vos = $this->comment_dao->
                buildNextChildCommentList($comment_id, $user_id, $last_time, $limit);
        return $child_comment_vos;
    }

}