<?php

namespace common\entity;

use common\components\DateTimeFormatter;
use Yii;
use yii\data\ArrayDataProvider;

class HomeEntity implements Entity{

    /**
     * required
     * @type integer
     * @var
     */
    protected $current_user_login_id;

    /**
     * @var ArrayDataProvider
     */
    private $thread_list;

    /**
     * @var string | null
     */
    private $issue_name;

    /**
     * @var boolean
     */
    private $user_followed_issue;

    /**
     * @var array
     */
    private $user_followed_issue_list;
    /**
     * @var integer
     */
    private $issue_num_followers;

    private $user_email_auth;

    private $trending_topic_list;

    /**
     * HomeEntity constructor.
     * @param $id
     */
    public function __construct( $current_user_login_id){
        $this->current_user_login_id = $current_user_login_id;
    }


    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    /**
     * @return mixed
     */
    public function getCurrentUserLoginId()
    {
        return $this->current_user_login_id;
    }

    /**
     * @param mixed $current_user_login_id
     */
    public function setCurrentUserLoginId($current_user_login_id)
    {
        $this->current_user_login_id = $current_user_login_id;
    }

    /**
     * @return array
     */
    public function getThreadList()
    {
        return $this->thread_list;
    }

    /**
     * @param array $thread_list
     */
    public function setThreadList($thread_list)
    {
        $this->thread_list = $thread_list;
    }



    /**
     * @return int
     */
    public function isBelongToCurrentUser(){
        if (\Yii::$app->user->isGuest) {
            $belongs = 0;
        }
        else {
            if(\Yii::$app->user->getId()== $this->getCurrentUserLoginId()){
                $belongs = 1;
            } else {
                $belongs = 0;
            }
        }

        return $belongs;

    }

    public function hasIssue(){
        return ($this->issue_name !== null);
    }

    /**
     * @return null|string
     */
    public function getIssueName()
    {
        return $this->issue_name;
    }

    /**
     * @param null|string $issue_name
     */
    public function setIssueName($issue_name)
    {
        $this->issue_name = $issue_name;
    }

    /**
     * @return boolean
     */
    public function isUserFollowedIssue()
    {
        return $this->user_followed_issue;
    }

    /**
     * @param boolean $user_followed_issue
     */
    public function setUserFollowedIssue($user_followed_issue)
    {
        $this->user_followed_issue = $user_followed_issue;
    }

    /**
     * @return int
     */
    public function getIssueNumFollowers()
    {
        return $this->issue_num_followers;
    }

    /**
     * @param int $issue_num_followers
     */
    public function setIssueNumFollowers($issue_num_followers)
    {
        $this->issue_num_followers = $issue_num_followers;
    }

    /**
     * @return array
     */
    public function getUserFollowedIssueList()
    {
        return $this->user_followed_issue_list;
    }

    /**
     * @param array $user_followed_issue_list
     */
    public function setUserFollowedIssueList($user_followed_issue_list)
    {
        $this->user_followed_issue_list = $user_followed_issue_list;
    }

    /**
     * @return mixed
     */
    public function getUserEmailAuth()
    {
        return $this->user_email_auth;
    }

    /**
     * @param mixed $user_email_auth
     */
    public function setUserEmailAuth($user_email_auth)
    {
        $this->user_email_auth = $user_email_auth;
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



}