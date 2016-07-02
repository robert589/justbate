<?php
namespace frontend\vo;
class SiteVo implements Vo {

    private $issue_followed_by_user;
    private $trending_topic_list;
    private $user_follow_issue;
    private $num_followers_of_issue;
    private $has_issue;
    private $issue_name;
    private $thread_list_provider;
    private $popular_issue_list;

    public function __construct(SiteVoBuilder $builder)
    {
        $this->issue_followed_by_user = $builder->getIssueFollowedByUser();
        $this->trending_topic_list = $builder->getTrendingTopicList();
        $this->user_follow_issue = $builder->getUserFollowIssue();
        $this->num_followers_of_issue = $builder->getNumFollowersOfIssues();
        $this->has_issue = $builder->getHasIssue();
        $this->issue_name = $builder->getIssueName();
        $this->thread_list_provider = $builder->getThreadListProvider();
        $this->popular_issue_list = $builder->getPopularIssueList();
    }

    /**
     * @return mixed
     */
    public function getIssueFollowedByUser()
    {
        if($this->issue_followed_by_user === null){
            return [];
        }


        return $this->issue_followed_by_user;
    }

    /**
     * @return mixed
     */
    public function getTrendingTopicList()
    {
        return $this->trending_topic_list;
    }

    /**
     * @return mixed
     */
    public function getUserFollowIssue()
    {
        return $this->user_follow_issue;
    }

    /**
     * @return mixed
     */
    public function getNumFollowersOfIssue()
    {
        return $this->num_followers_of_issue;
    }

    /**
     * @return mixed
     */
    public function getHasIssue()
    {
        return $this->has_issue;
    }

    /**
     * @return mixed
     */
    public function getIssueName()
    {
        return $this->issue_name;
    }

    /**
     * @return mixed
     */
    public function getThreadListProvider()
    {
        return $this->thread_list_provider;
    }

    /**
     * @return mixed
     */
    public function getPopularIssueList()
    {
        return $this->popular_issue_list;
    }



    static function createBuilder()
    {
        // TODO: Implement createBuilder() method.
        return new SiteVoBuilder();
    }


}
