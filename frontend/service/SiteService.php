<?php
namespace frontend\service;

use common\models\ThreadVote;
use frontend\dao\ListNotificationDao;
use frontend\dao\SiteDao;
use frontend\dao\ThreadDao;
use frontend\vo\ListNotificationVoBuilder;
use frontend\vo\SiteVo;
use frontend\vo\SiteVoBuilder;
use frontend\vo\ThreadVo;
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


}