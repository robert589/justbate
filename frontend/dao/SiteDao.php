<?php
namespace frontend\dao;

use common\entity\ChildCommentVo;
use common\models\ChildComment;
use common\models\Issue;
use common\models\Notification;
use common\models\Thread;
use common\models\ThreadComment;
use common\models\ThreadVote;
use common\models\UserEmailAuthentication;
use common\models\UserFollowedIssue;
use frontend\vo\ChildCommentVoBuilder;
use frontend\vo\CommentVoBuilder;
use frontend\vo\ListNotificationVoBuilder;
use frontend\vo\NotificationVo;
use frontend\vo\NotificationVoBuilder;
use frontend\vo\SiteVoBuilder;
use frontend\vo\ThreadCommentVoBuilder;
use frontend\vo\ThreadVoBuilder;
use yii\data\ArrayDataProvider;

class SiteDao{

    private $thread_dao;

    public function  __construct()
    {
        $this->thread_dao = new ThreadDao();
    }

    const ISSUE_NUM_FOLLOWERS = "SELECT count(*) from user_followed_issue where issue_name = :issue_name";

    const THREAD_LISTS = "Select parent_thread_info.* ,
                                thread_vote.choice_text,
                                count(parent_thread_info.thread_id) * 8 +
                                (viewed.thread_id is null) * (5) + 
                                (parent_thread_info.total_comments <> 0) * 3 as parameter   ,
                                (anonymous.anonymous_id) as thread_anonymous
                                
                          from(
                                Select thread_info.*, count(comments.comment_id) as total_comments
                                from (Select thread.*, user.id, user.first_name, user.last_name, user.photo_path
                                      from thread, user
                                      where thread.user_id = user.id and
                                            thread_status = 10
                                ) thread_info
                                left join (select thread_comment.comment_id, thread_comment.thread_id
                                                        from thread_comment, comment
                                                  where thread_comment.comment_id = comment.comment_id and
                                                  comment.comment_status = 10) comments
                                on thread_info.thread_id = comments.thread_id
                                group by thread_info.thread_id
                                order by (created_at) desc

                            ) parent_thread_info
                            left join thread_vote
                            on parent_thread_info.thread_id = thread_vote.thread_id and thread_vote.user_id = :user_id
                            left join (SELECT thread_id, user_followed_issue.issue_name as issue_followed_name from thread_issue, user_followed_issue
                                       where thread_issue.issue_name = user_followed_issue.issue_name
                                      and user_followed_issue.user_id = :user_id) followed_issue
                            on followed_issue.thread_id = parent_thread_info.thread_id
                            left join (SELECT thread_id, anonymous_id
                                       from thread_anonymous
                                       where thread_anonymous.user_id = :user_id) anonymous
                            on parent_thread_info.thread_id = anonymous.thread_id
                            left join (SELECT thread_id
                                        from thread_view
                                        where thread_view.user_id = :user_id) viewed
                            on parent_thread_info.thread_id = viewed.thread_id
                            group by(parent_thread_info.thread_id)
                            order by(parameter) desc";

    const THREAD_LISTS_WITH_ISSUE = "Select parent_thread_info.* ,
                        		thread_vote.choice_text,
                                count(parent_thread_info.thread_id) * 8 +
                               ((100000 * parent_thread_info.created_at + 100000) / now()- 7) * 2 as parameter   ,
                               (anonymous.anonymous_id) as thread_anonymous
                        from(
							Select thread_info.*, count(comments.comment_id) as total_comments
							from (Select thread.*, user.id, user.first_name, user.last_name, user.photo_path
								  from thread, user, thread_issue, issue
									  where thread.user_id = user.id and
								  thread_status = 10 and
								  thread_issue.thread_id = thread.thread_id
								and issue.issue_name = :issue_name
								and issue.issue_name = thread_issue.issue_name
							) thread_info
							left join (select thread_comment.comment_id, thread_comment.thread_id
										from thread_comment, comment
									  where thread_comment.comment_id = comment.comment_id and
									  comment.comment_status = 10) comments
							on thread_info.thread_id = comments.thread_id
							group by thread_info.thread_id
							order by (created_at) desc

						) parent_thread_info
						left join thread_vote
						on parent_thread_info.thread_id = thread_vote.thread_id and thread_vote.user_id = :user_id
                        left join (SELECT thread_id, user_followed_issue.issue_name as issue_followed_name from thread_issue, user_followed_issue
                                   where thread_issue.issue_name = user_followed_issue.issue_name
                                  and user_followed_issue.user_id = :user_id) followed_issue
                        on followed_issue.thread_id = parent_thread_info.thread_id
                        left join (SELECT thread_id, anonymous_id
                                   from thread_anonymous
                                   where thread_anonymous.user_id = :user_id) anonymous
                        on parent_thread_info.thread_id = anonymous.thread_id
                        group by(parent_thread_info.thread_id)
                        order by(parameter) desc";

    const SEARCH_ALL_ISSUES = "SELECT issue.issue_name, (current_user_followed_issue.user_id is not null) as follow_by_current_user
                            FROM `issue`
                            left join
                            (SELECT * from user_followed_issue where user_id = :user_id) current_user_followed_issue
                            on issue.issue_name = current_user_followed_issue.issue_name
                            where issue.issue_status = 10 ";
    
    public function getThreadLists( $current_user_id, $issue_name, SiteVoBuilder $builder){
        if($issue_name !== null){
            $results = \Yii::$app->db->createCommand(self::THREAD_LISTS_WITH_ISSUE)->
            bindParam(':issue_name', $issue_name)->
            bindParam(':user_id', $current_user_id)
                ->queryAll();
        }
        else {
            $results = \Yii::$app->db->createCommand(self::THREAD_LISTS)->
                bindParam(':user_id', $current_user_id)
                ->queryAll();


        }
        $thread_list = array();

        foreach($results as $result){
            //map database result
            $thread_builder = new ThreadVoBuilder();
            $thread_builder->setThreadId($result['thread_id']);
            $thread_builder->setThreadCreatorUserId($result['user_id']);
            $thread_builder->setTitle($result['title']);
            $thread_builder->setCurrentUserAnonymous($result['thread_anonymous']);
            $thread_builder->setThreadStatus($result['thread_status']);
            $thread_builder->setDescription($result['description']);
            $thread_builder->setUpdatedAt($result['updated_at']);
            $thread_builder->setTotalComments($result['total_comments']);
            $thread_builder->setCurrentUserVote($result['choice_text']);
            $thread_builder = $this->thread_dao->getOneComment($result['thread_id'], $current_user_id, $thread_builder);
            $thread_builder = $this->thread_dao->getThreadIssues($result['thread_id'], $thread_builder);
            $thread_builder = $this->thread_dao->getUserChoiceOnly($result['thread_id'] , $current_user_id, $thread_builder);
            $thread_builder = $this->thread_dao->getThreadChoices($result['thread_id'], $thread_builder);
            $thread_list[] = $thread_builder->build();
        }
        $data_provider = new ArrayDataProvider([
            'allModels' => $thread_list,
            'pagination' => [
                'pageSize' =>10,
            ],
        ]);
        $builder->setThreadListProvider($data_provider);
        return $builder;
    }

    /**
     * @param $issue_name
     * @param SiteVoBuilder $builder
     */
    public function issueNumFollowers($issue_name, SiteVoBuilder $builder){
        $issue_num_followers = null;
        if($issue_name !== null){
            $issue_num_followers = (int) \Yii::$app->db->createCommand(self::ISSUE_NUM_FOLLOWERS)->
                        bindParam(":issue_name", $issue_name)->
                        queryScalar();
            $builder->setNumFollowersOfIssues($issue_num_followers);
        }
        return $builder;
    }

    public function userFollowedIssue($current_user_id, $issue_name, SiteVoBuilder $builder) {
        $userFollowedIssue = null;
        if($issue_name !== null) {
            $userFollowedIssue = UserFollowedIssue::find()->where(['user_id' => $current_user_id, 'issue_name' => $issue_name])
                    ->exists();
            $builder->setUserFollowIssue($userFollowedIssue);

        }
        return $builder;

    }

    public function getFollowedIssueList($current_user_id, SiteVoBuilder $builder){
        $issue_list = UserFollowedIssue::find()->where(['user_id' => $current_user_id])->all();
        $issues = [];

        foreach($issue_list as $item) {
            $issue['url'] = \Yii::$app->request->baseUrl . '/issue/' . $item['issue_name'];
            $issue['label'] = $item['issue_name'];
            $issue['template'] =  '<a href="{url}" data-pjax="0">{icon}{label}</a>';
             $issues[] = $issue;
        }
        $builder->setIssueFollowedByUser($issues);
        return $builder;
    }

    /**
     * @param SiteVoBuilder $builder
     * @return SiteVoBuilder
     */
    public function getTrendingTopicList(SiteVoBuilder $builder){
        $trending_topic_list = Thread::getTop10TrendingTopic();
        $mapped_trending_topic_list = array();
        foreach($trending_topic_list as $trending_topic){
            $mapped_trending_topic['label'] = $trending_topic['title'];
            $mapped_trending_topic['url'] = \Yii::$app->request->baseUrl . '/thread/' . $trending_topic['thread_id']. '/'
                . str_replace(' ', '-' , strtolower($trending_topic['title']));

            $mapped_trending_topic_list[] = $mapped_trending_topic;
        }
        $builder->setTrendingTopicList($mapped_trending_topic_list);
        return $builder;
    }

    /**
     * @param SiteVoBuilder $builder
     * @return SiteVoBuilder
     */
    public function getPopularIssueList(SiteVoBuilder $builder){
        $popular_issue_list = Issue::getPopularIssue();
        $builder->setPopularIssueList($popular_issue_list);
        return $builder;
    }

    /**
     * Json response
     */
    public function getAllIssues($user_id, $query) {
        if($q !== null || $q !== '') {

            return \Yii::$app->db->createCommand(self::THREAD_LISTS_WITH_ISSUE . ' and issue.issue_name like :query')->
                                    bindParam(':user_id', $user_id)
                                    ->bindParam(':query', $query)
                                  ->queryAll();
        }
            return \Yii::$app->db->createCommand(self::THREAD_LISTS_WITH_ISSUE)->
                                    bindParam(':user_id', $user_id)
                                  ->queryAll();
    }
}