<?php
namespace frontend\service;

use common\models\ThreadVote;
use frontend\dao\ListNotificationDao;
use frontend\dao\ThreadDao;
use frontend\vo\ListNotificationVoBuilder;
use frontend\vo\ThreadVo;
use frontend\vo\ThreadVoBuilder;

class ThreadService{

    private $thread_dao;

    function __construct(ThreadDao $thread_dao)
    {
        $this->thread_dao = $thread_dao;
    }



    /**
     * @param $thread_id
     * @param $user_id
     * @param ThreadVoBuilder $builder
     * @return \frontend\vo\ThreadVo
     */
    public function getThreadInfo($thread_id, $user_id, ThreadVoBuilder $builder){
        $builder = $this->thread_dao->getThreadInfo($thread_id, $user_id, $builder);
        $builder = $this->thread_dao->getThreadChoices($thread_id, $builder);
        $builder = $this->thread_dao->getAllCommentProviders($thread_id, $builder->getMappedChoices(), $user_id, $builder);
        return $builder->build();
    }

    public function getThreadInfoVote($thread_id, $user_id, ThreadVoBuilder $builder) {
        $builder->setThreadId($thread_id);
        $builder = $this->thread_dao->getThreadChoices($thread_id, $builder);
        $builder = $this->thread_dao->getUserChoiceOnly($thread_id,$user_id, $builder);
        return $builder->build();
    }
    
    /**
     * 
     * @param type $thread_id
     * @param type $user_id
     * @param ThreadVoBuilder $builder
     * @return ThreadVo 
     */
    public function getThreadInfoForRetrieveCommentInput($thread_id, $user_id, ThreadVoBuilder $builder) {
        $builder->setThreadId($thread_id);
        $builder = $this->thread_dao->getUserChoiceOnly($thread_id,$user_id, $builder);
        $builder = $this->thread_dao->getAnonymous($thread_id, $user_id, $builder);
        $builder = $this->thread_dao->getCurrentUserComment($thread_id, $user_id, $builder);
        return $builder->build();
    }

    public function getThreadInfoAfterEdit($thread_id, $current_user_id, $title, $description, ThreadVoBuilder $builder) {
        $builder->setTitle($title);
        $builder->setDescription($description);
        $builder = $this->thread_dao->getThreadChoices($thread_id, $builder);
        $builder = $this->thread_dao->getUserChoiceOnly($thread_id, $current_user_id, $builder);
        $builder = $this->thread_dao->getThreadIssues($thread_id, $builder);
        return $builder->build();
    }



}