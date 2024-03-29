<?php
namespace frontend\service;
use frontend\dao\SiteDao;
use frontend\vo\SiteVoBuilder;
use frontend\vo\ThreadVoBuilder;

class SiteService{

    private $site_dao;

    function __construct(SiteDao $site_dao)
    {
        $this->site_dao = $site_dao;
    }

    /**
     * @param $thread_id
     * @param $user_id
     * @param ThreadVoBuilder $builder
     * @return \frontend\vo\ThreadVo
     */
    public function getHomeInfo($user_id, $issue_name, SiteVoBuilder $builder){
        $builder->setIssueName($issue_name);
        $builder = $this->site_dao->getThreadLists($user_id, $issue_name, $builder);
        $builder = $this->site_dao->issueNumFollowers($issue_name, $builder);
        $builder = $this->site_dao->userFollowedIssue($user_id,$issue_name,$builder);
        $builder = $this->site_dao->getTrendingTopicList($builder);
        $builder = $this->site_dao->getPopularIssueList($builder);
        $builder = $this->site_dao->getFollowedIssueList($user_id, $builder);

        return $builder->build();
    }

    /**
     * For Ajax Response
     * @param $user_id
     */
    public function getAllIssues($user_id, $query) {
        return $this->site_dao->getAllIssues($user_id, $query);
    }
    
    public function getNewestThread($user_id, SiteVoBuilder $builder) {
        $builder = $this->site_dao->getNewestThread($user_id, $builder);
        $builder = $this->site_dao->getTrendingTopicList($builder);
        $builder = $this->site_dao->getPopularIssueList($builder);
        $builder = $this->site_dao->getFollowedIssueList($user_id, $builder);

        return $builder->build();
    }
    
    public function getIssueWithStatus($user_id, $query) {
        
    }

}