<?php

namespace frontend\vo;

class SiteVoBuilder implements  Builder{


    private $issue_followed_by_user;
    private $trending_topic_list;
    private $user_follow_issue;
    private $num_followers_of_issues;
    private $has_issue;
    private $issue_name;
    private $thread_list_provider;
    private $popular_issue_list;

    function build()
    {
        // TODO: Implement build() method.
        return new SiteVo($this);
    }

    /**
     * @return mixed
     */
    public function getIssueFollowedByUser()
    {
        return $this->issue_followed_by_user;
    }

    /**
     * @param mixed $issue_followed_by_user
     */
    public function setIssueFollowedByUser($issue_followed_by_user)
    {
        $this->issue_followed_by_user = $issue_followed_by_user;
    }

    /**
     * @return mixed
     */
    public function getTrendingTopicList()
    {
        return $this->trending_topic_list;
    }

    /**
     * @param mixed $trending_topic_list
     */
    public function setTrendingTopicList($trending_topic_list)
    {
        $this->trending_topic_list = $trending_topic_list;
    }

    /**
     * @return mixed
     */
    public function getUserFollowIssue()
    {
        return $this->user_follow_issue;
    }

    /**
     * @param mixed $user_follow_issue
     */
    public function setUserFollowIssue($user_follow_issue)
    {
        $this->user_follow_issue = $user_follow_issue;
    }

    /**
     * @return mixed
     */
    public function getNumFollowersOfIssues()
    {
        return $this->num_followers_of_issues;
    }

    /**
     * @param mixed $num_followers_of_issues
     */
    public function setNumFollowersOfIssues($num_followers_of_issues)
    {
        $this->num_followers_of_issues = $num_followers_of_issues;
    }

    /**
     * @return mixed
     */
    public function getHasIssue()
    {
        return $this->has_issue;
    }

    /**
     * @param mixed $has_issue
     */
    public function setHasIssue($has_issue)
    {
        $this->has_issue = $has_issue;
    }

    /**
     * @return mixed
     */
    public function getIssueName()
    {
        return $this->issue_name;
    }

    /**
     * @param mixed $issue_name
     */
    public function setIssueName($issue_name)
    {
        $this->issue_name = $issue_name;
    }

    /**
     * @return mixed
     */
    public function getThreadListProvider()
    {
        return $this->thread_list_provider;
    }

    /**
     * @param mixed $thread_list_provider
     */
    public function setThreadListProvider($thread_list_provider)
    {
        $this->thread_list_provider = $thread_list_provider;
    }

    /**
     * @return mixed
     */
    public function getPopularIssueList()
    {
        return $this->popular_issue_list;
    }

    /**
     * @param mixed $popular_issue_list
     */
    public function setPopularIssueList($popular_issue_list)
    {
        $this->popular_issue_list = $popular_issue_list;
    }


}