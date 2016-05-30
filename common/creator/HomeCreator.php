<?php

namespace common\creator;
use common\entity\HomeEntity;
use common\entity\ThreadEntity;
use common\models\Choice;
use common\models\Comment;
use common\models\Issue;
use common\models\Thread;
use common\models\ThreadIssue;
use common\models\UserEmailAuthentication;
use common\models\UserFollowedIssue;
use yii\base\Exception;
use yii\data\ArrayDataProvider;

class HomeCreator implements CreatorInterface{

    const NEED_THREAD_LISTS  = 1;

    const NEED_USER_FOLLOWED_ISSUE = 2;

    const NEED_ISSUE_NUM_FOLLOWERS = 3;

    const NEED_TRENDING_TOPIC_LIST = 4;

    const NEED_USER_FOLLOWED_ISSUE_LIST = 5;

    const NEED_USER_EMAIL = 6;

    const NEED_POPULAR_ISSUE_LIST = 7;

    /**
     * @var HomeEntity
     */
    public $home;

    /**
     * HomeCreator constructor.
     * @param HomeEntity $home
     */
    function __construct(HomeEntity $home)
    {
        $this->home
            = $home;

        //checking whether the model can be used
        $this->validateModel();
    }

    /**
     * @param array $config
     * @return ThreadEntity
     */
    public function get(array $needs){
        foreach($needs as $need){
            switch($need){
                case self::NEED_THREAD_LISTS:
                    $this->getThreadLists();
                    break;
                case self::NEED_ISSUE_NUM_FOLLOWERS:
                    $this->issueNumFollowers();
                    break;
                case self::NEED_USER_FOLLOWED_ISSUE:
                    $this->userFollowedIssue();
                    break;
                case self::NEED_TRENDING_TOPIC_LIST:
                    $this->getTrendingTopicList();
                    break;
                case self::NEED_USER_FOLLOWED_ISSUE_LIST:
                    $this->getFollowedIssueList();
                    break;
                case self::NEED_USER_EMAIL:
                    $this->getUserEmailAuth();
                    break;
                case self::NEED_POPULAR_ISSUE_LIST:
                    $this->getPopularIssueList();
                    break;
                default:
                    break;
            }
        }
        return $this->home;
    }

    function validateModel(){
        //id must not empty
        if(is_nan($this->home->getCurrentUserLoginId())){
            throw new Exception("Login User id must not be empty");
        }
    }

    /**
     *
     */
    private function getThreadLists(){
        $results =  ($this->home->hasIssue() === true) ? Thread::getThreads($this->home->getCurrentUserLoginId(), $this->home->getIssueName())
                                        : Thread::getThreads($this->home->getCurrentUserLoginId());


        $thread_list = array();

        foreach($results as $result){
            //map database result
            $thread  = new ThreadEntity($result['thread_id'],$this->home->getCurrentUserLoginId());
            $thread->setDataFromArray($result);

            //load other data
            $creator = (new CreatorFactory())->getCreator(CreatorFactory::THREAD_CREATOR, $thread);
            $thread = $creator->get([ThreadCreator::NEED_CHOOSE_ONE_COMMENT,
                                     ThreadCreator::NEED_THREAD_CHOICE,
                                     ThreadCreator::NEED_THREAD_ISSUE,
                                     ThreadCreator::NEED_USER_CHOICE_ON_THREAD_ONLY]);
            $thread_list[] = $thread;
        }

        $data_provider = new ArrayDataProvider([
            'allModels' => $thread_list,
            'pagination' => [
                'pageSize' =>10,
            ],
        ]);

        $this->home->setThreadList($data_provider);
    }

    private function issueNumFollowers(){
        $issue_num_followers = ($this->home->hasIssue()) ? UserFollowedIssue::getTotalFollowedIssue($this->home->getIssueName()) : null;
        $this->home->setIssueNumFollowers($issue_num_followers);
    }

    private function userFollowedIssue(){
        $userFollowedIssue = ($this->home->hasIssue()) ?
            UserFollowedIssue::isFollower($this->home->getCurrentUserLoginId(),
                                            $this->home->getIssueName())
                                : null;

        $this->home->setUserFollowedIssue($userFollowedIssue);

    }

    private function getFollowedIssueList(){
        $issue_list = UserFollowedIssue::getFollowedIssue($this->home->getCurrentUserLoginId());

        $this->home->setUserFollowedIssueList($issue_list);

    }

    /**
     * @return array
     */
    private function getTrendingTopicList(){
        $trending_topic_list = Thread::getTop10TrendingTopic();

        $mapped_trending_topic_list = array();

        foreach($trending_topic_list as $trending_topic){
            $mapped_trending_topic['label'] = $trending_topic['title'];
            $mapped_trending_topic['url'] = \Yii::$app->request->baseUrl . '/thread/' . $trending_topic['thread_id']. '/'
                . str_replace(' ', '-' , strtolower($trending_topic['title']));

            $mapped_trending_topic_list[] = $mapped_trending_topic;

        }
        $this->home->setTrendingTopicList($mapped_trending_topic_list);
    }

    /**
     *
     */
    private function getUserEmailAuth(){
        $user_email_auth = UserEmailAuthentication::findOne(['user_id' => $this->home->getCurrentUserLoginId()]);
        $this->home->setUserEmailAuth($user_email_auth);
    }

    private function getPopularIssueList(){
        $popular_issue_list = Issue::getPopularIssue();
        $this->home->setPopularIssueList($popular_issue_list);
    }
}