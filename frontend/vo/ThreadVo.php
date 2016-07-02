<?php

namespace frontend\vo;

use common\components\LinkConstructor;
use frontend\vo\CommentVo;
use frontend\vo\ThreadCommentVoBuilder;
use yii\data\ArrayDataProvider;

class ThreadVo implements Vo{

    private $thread_id;

    private $thread_comment_list;

    private $title;

    private $description;

    private $created_at;

    private $updated_at;

    private $thread_status;

    private $thread_creator_user_id;

    private $current_user_vote;

    private $thread_issues;

    private $mapped_choices;

    private $choices;

    private $current_user_anonymous;

    private $total_comments;

    /**
     * @var ThreadCommentVo
     */
    private $chosen_comment;

    /**
     * @return mixed
     */
    public function getCurrentUserAnonymous()
    {
        return $this->current_user_anonymous;
    }




    function __construct(ThreadVoBuilder $builder){
        $this->thread_id = $builder->getThreadId();
        $this->thread_comment_list = $builder->getThreadCommentList();
        $this->title = $builder->getTitle();
        $this->description = $builder->getDescription();
        $this->created_at = $builder->getCreatedAt();
        $this->updated_at = $builder->getUpdatedAt();
        $this->thread_status = $builder->getThreadStatus();
        $this->thread_creator_user_id = $builder->getThreadCreatorUserId();
        $this->current_user_vote = $builder->getCurrentUserVote();
        $this->thread_issues = $builder->getThreadIssues();
        $this->mapped_choices = $builder->getMappedChoices();
        $this->choices = $builder->getChoices();
        $this->current_user_anonymous = $builder->getCurrentUserAnonymous();
        $this->total_comments = $builder->getTotalComments();
        $this->chosen_comment = $builder->getChosenComment();
    }
    /**
     * @return mixed
     */
    public function getThreadCommentList()
    {
        return $this->thread_comment_list;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @return mixed
     */
    public function getThreadStatus()
    {
        return $this->thread_status;
    }

    /**
     * @return mixed
     */
    public function getThreadCreatorUserId()
    {
        return $this->thread_creator_user_id;
    }

    /**
     * @return mixed
     */
    public function getCurrentUserVote()
    {
        return $this->current_user_vote;
    }

    /**
     * @return mixed
     */
    public function getThreadIssues()
    {
        return $this->thread_issues;
    }

    /**
     * @return mixed
     */
    public function getMappedChoices()
    {
        return $this->mapped_choices;
    }

    /**
     * @return mixed
     */
    public function getChoices()
    {
        return $this->choices;
    }


    static function createBuilder(){
        return new ThreadVoBuilder();
    }


    /**
     * @return mixed
     */
    public function getThreadId()
    {
        return $this->thread_id;
    }

    /**
     * @return int
     */
    public function belongToCurrentUser(){
        if (\Yii::$app->user->isGuest) {
            $belongs = 0;
        }
        else {
            if(\Yii::$app->user->getId()== $this->thread_creator_user_id){
                $belongs = 1;
            } else {
                $belongs = 0;
            }
        }

        return $belongs;

    }

    public function getThreadLink(){
        return LinkConstructor::threadLinkConstructor($this->thread_id, $this->title);
    }

    public function isGuest(){
        return \Yii::$app->user->getId() === null;
    }

    public function hasVote(){
        return $this->current_user_vote !== null;
    }

    public function getCommentRequestUrl(){
        return  \Yii::$app->request->baseUrl . '/site/get-comment?thread_id=' . $this->thread_id ;

    }

    /**
     * @return mixed
     */
    public function getTotalComments()
    {
        return $this->total_comments;
    }

    /**
     * @return ThreadCommentVo
     */
    public function hasChosenComment()
    {
        return $this->chosen_comment !== null;
    }

    /**
     * @return ThreadCommentVo
     */
    public function getChosenComment()
    {
        return $this->chosen_comment;
    }



}