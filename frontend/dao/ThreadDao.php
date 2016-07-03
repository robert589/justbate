<?php
namespace frontend\dao;

use common\entity\ChildCommentVo;
use common\models\ChildComment;
use common\models\Notification;
use common\models\Thread;
use common\models\ThreadAnonymous;
use common\models\ThreadComment;
use common\models\ThreadIssue;
use common\models\ThreadVote;
use frontend\vo\ChildCommentVoBuilder;
use frontend\vo\CommentVoBuilder;
use frontend\vo\ListNotificationVoBuilder;
use frontend\vo\NotificationVo;
use frontend\vo\NotificationVoBuilder;
use frontend\vo\ThreadCommentVoBuilder;
use frontend\vo\ThreadVo;
use frontend\vo\ThreadVoBuilder;
use yii\data\ArrayDataProvider;

class ThreadDao{
        const GET_ONE_COMMENT = "
            SELECT chosen_comment.*,
                    CASE when (user_vote.comment_id is not null) then user_vote.vote else null end as current_user_vote,
                    count(case when total_vote.vote = 1 then 1 else null end) as total_like,
                    count(case when total_vote.vote = -1 then 1 else null end) as total_dislike
            from(
                SELECT comment_info.*,
                      (thread_anonymous.anonymous_id) as comment_anonymous
               from (SELECT comment.*, thread_comment.thread_id, thread_comment.choice_text, user.first_name, user.last_name,
                            user.photo_path, user.username
                     from thread_comment,comment, user
                     where thread_comment.thread_id = :thread_id and thread_comment.comment_id = comment.comment_id
                       and comment.user_id = user.id and comment.comment_status = 10) as comment_info
                     left join thread_anonymous
                      on thread_anonymous.user_id = comment_info.user_id and thread_anonymous.thread_id = comment_info.thread_id
                     limit 1) chosen_comment
            left join comment_vote user_vote
            on chosen_comment.comment_id = user_vote.comment_id and user_vote.user_id = :user_id
            left join comment_vote total_vote
            on total_vote.comment_id  = chosen_comment.comment_id";

        const COMMENT_BY_CHOICE_TEXT = "
            SELECT comments.*,
                    (case comment_vote.user_id when :user_id then vote else null end) as vote,
                    COALESCE (count(case vote when 1 then 1 else null end),0)as total_like,
                    COALESCE (count(case vote when -1 then 1 else null end),0) as total_dislike,
                    (thread_anonymous.anonymous_id) as comment_anonymous
            FROM (
                SELECT  comment.* , thread_comment.choice_text , thread_comment.thread_id, user.first_name,
                                                user.last_name, user.username, user.photo_path
                from thread_comment,comment, user, thread_anonymous
                where thread_comment.thread_id = :thread_id and
                thread_comment.choice_text= :choice_text and
                thread_comment.comment_id = comment.comment_id 	and
                user.id = comment.user_id and
                comment_status = 10
                ) comments
            LEFT JOIN comment_vote
            on comment_vote.comment_id = comments.comment_id
            left join thread_anonymous
            on thread_anonymous.thread_id = comments.thread_id and thread_anonymous.user_id  = comments.user_id
            group by
             comments.comment_id
            order by total_like desc";

        CONST THREAD_INFO = "SELECT TU.*, thread_vote.choice_text as current_user_vote, issues, choices
                        FROM (SELECT thread.*, user.id, user.first_name, user.last_name
                              from thread, user
                              where thread.user_id = user.id and thread_id = :thread_id) TU
                        left join thread_vote
                        on TU.thread_id = thread_vote.thread_id and thread_vote.user_id = :user_id
                        left join
                             (SELECT  group_concat(thread_issue.issue_name SEPARATOR '%,%') as issues, thread.thread_id
                              FROM thread_issue, thread
                              where thread.thread_id = :thread_id and thread_issue.thread_id = thread.thread_id
                              ) thread_issues
                        on thread_issues.thread_id = TU.thread_id
                         left join
                             (SELECT  group_concat(choice.choice_text SEPARATOR '%,%') as choices, thread_id
                              FROM choice
                              where choice.thread_id = :thread_id
                              ) thread_choices
                        on thread_choices.thread_id = TU.thread_id";

        const THREAD_INFO_FOR_COMMENT_INPUT_BOX = "SELECT (SElect thread_anonymous.anonymous_id as anonymous from thread_anonymous
                                                            where thread_id = :thread_id  and user_id = :user_id) as anonymous,
                                                            (SELECT thread_vote.choice_text from thread_vote
                                                             where thread_id = :thread_id  and user_id = :user_id) as choice_text
                                                    FROM THREAD
                                                    limit 1";

        CONST THREAD_CHOICE = "Select choice_and_its_voters.choice_text as choice_text,
                                    total_voters,
                                    count(comment_id) as total_comments
                                from(
                                    select thread_choice.choice_text,
                                           count(user_id) as total_voters
                                    from (select choice_text from choice where thread_id = :thread_id) thread_choice
                                    left join
                                            (select user_id, choice_text
                                             from thread_vote
                                             where thread_id = :thread_id) current_thread_vote
                                    on thread_choice.choice_text = current_thread_vote.choice_text
                                    group by(thread_choice.choice_text)
                                    ) choice_and_its_voters
                                left join
                                    ( select thread_comment.* from thread_comment,comment where thread_id = :thread_id and
                                     comment.comment_id = thread_comment.comment_id and comment.comment_status = 10) comment_with_id
                                on comment_with_id.choice_text = choice_and_its_voters.choice_text
                                group by (choice_and_its_voters.choice_text)
                                order by total_comments desc";

    public function getThreadInfo($thread_id, $user_id, ThreadVoBuilder $builder){
        //mapping
        $result = \Yii::$app->db
            ->createCommand(self::THREAD_INFO)
            ->bindValue(':thread_id', $thread_id)
            ->bindValue(':user_id', $user_id)
            ->queryOne();
        $builder->setTitle($result['title']);
        $builder->setDescription($result['description']);
        $builder->setThreadCreatorUserId($result['user_id']);
        $builder->setCreatedAt($result['created_at']);
        $builder->setUpdatedAt($result['updated_at']);
        $builder->setThreadStatus($result['thread_status']);
        $builder->setCurrentUserVote($result['current_user_vote']);
        $builder->setThreadIssues($result['issues']);
        $builder->setChoices($result['choices']);
        $builder->setThreadId($result['thread_id']);
        return $builder;


    }

    public function getThreadIssues($thread_id, ThreadVoBuilder $builder) {
        $builder->setThreadIssues(ThreadIssue::getIssue($thread_id));

        return $builder;
    }

    public function getThreadChoices($thread_id, ThreadVoBuilder $builder){
        $result =  \Yii::$app->db->createCommand(self::THREAD_CHOICE)->
        bindParam(':thread_id', $thread_id)->
        queryAll();
        $builder->setMappedChoices($result);
        return $builder;
    }

    public function getAllCommentProviders($thread_id, $thread_choices, $user_id = 0, ThreadVoBuilder $builder){
        //the prev $thread_choice is an associative array, convert to normal array
        //the prev $thread_chocie: e.g  ("agree" : "agree ( 0 voters), " disagree": "disagree (1 voters) "
        //initialize array
        $all_providers = array();
        $limit = 5;
        foreach($thread_choices as $thread_choice){
            //$thread_choice contains the choice of the thread, e.g = "Agree", "Disagree"
            $allModels = self::getCommentByChoiceText($thread_id, $thread_choice['choice_text'], $user_id, $builder);
            $dataProvider =new ArrayDataProvider([
                'allModels' => $allModels,
                'pagination' => [
                    'pageSize' =>$limit,

                ],

            ]);
            $all_providers[$thread_choice['choice_text'] . ' (' . count($allModels) . ')' ] = $dataProvider;
        }

        $builder->setThreadCommentList($all_providers);

        return $builder;
    }


    /**
     * @param $thread_id
     * @param $choice_text
     * @param $user_id
     * @param ThreadVoBuilder $builder
     * @return array
     */
    public static function getCommentByChoiceText($thread_id, $choice_text, $user_id, ThreadVoBuilder $builder ){


        $results = \Yii::$app->db
            ->createCommand(self::COMMENT_BY_CHOICE_TEXT)
            ->bindValues([':thread_id' => $thread_id])
            ->bindValues([':choice_text' => $choice_text] )
            ->bindValue(':user_id', $user_id)
            ->queryAll();

        //mapped data
        $thread_comment_list = array();

        foreach($results as $result){
            $thread_comment_builder = new ThreadCommentVoBuilder();
            $thread_comment_builder->setAnonymous($result['comment_anonymous']);
            $thread_comment_builder->setCreatedAt($result['created_at']);
            $thread_comment_builder->setComment($result['comment']);
            $thread_comment_builder->setCommentId($result['comment_id']);
            $thread_comment_builder->setCommentCreatorId($result['user_id']);
            $thread_comment_builder->setUpdatedAt($result['created_at']);
            $thread_comment_builder->setCommentStatus($result['comment_status']);
            $thread_comment_builder->setChoiceText($result['choice_text']);
            $thread_comment_builder->setParentThreadId($result['thread_id']);
            $thread_comment_builder->setCommentCreatorFirstName($result['first_name']);
            $thread_comment_builder->setCommentCreatorLastName($result['last_name']);
            $thread_comment_builder->setCommentCreatorUsername($result['username']);
            $thread_comment_builder->setCommentCreatorPhotoPath($result['photo_path']);
            $thread_comment_builder->setCurrentUserVote($result['vote']);
            $thread_comment_builder->setTotalLike($result['total_like']);
            $thread_comment_builder->setTotalDislike($result['total_dislike']);

            $thread_comment_list[] =  $thread_comment_builder->build();
        }

        return $thread_comment_list;

    }


    public  function getUserChoiceOnly($thread_id, $user_id,ThreadVoBuilder $builder){
        $result = ThreadVote::find()
            ->where(['thread_id' => $thread_id])
            ->andWhere(['user_id' => $user_id])->one();
        if($result !== null){
            $builder->setCurrentUserVote(  $result->choice_text   );
        }
        return $builder;
    }

    public function getThreadInfoForCommentInput($thread_id, $user_id, ThreadVoBuilder $builder){

        $result = \Yii::$app->db
            ->createCommand(self::THREAD_INFO_FOR_COMMENT_INPUT_BOX)
            ->bindValue(':thread_id', $thread_id) ->bindValue(':user_id', $user_id)
            ->queryOne();

        $builder->setCurrentUserAnonymous($result['anonymous']);
        $builder->setCurrentUserVote($result['choice_text']);

        return $builder;


    }

    public function getAnonymous($thread_id, $current_user_id, ThreadVoBuilder $builder) {
        $builder->setCurrentUserAnonymous(ThreadAnonymous::find()->where(['thread_id' => $thread_id, 'user_id' => $current_user_id])->exists());
        return $builder;
    }

    public function getOneComment($thread_id, $current_user_id, ThreadVoBuilder $builder){
        $result = \Yii::$app->db
            ->createCommand(self::GET_ONE_COMMENT)
            ->bindValues([':thread_id' => $thread_id])
            ->bindValue(':user_id', $current_user_id)
            ->queryOne();
        if($result['comment_id'] === null){
            $builder->setChosenComment(null);
            return $builder;
        }



        $comment_builder = new ThreadCommentVoBuilder();

        $comment_builder->setAnonymous($result['comment_anonymous']);
        $comment_builder->setCommentCreatorId($result['user_id']);
        $comment_builder->setCreatedAt($result['created_at']);
        $comment_builder->setComment($result['comment']);
        $comment_builder->setUpdatedAt($result['updated_at']);
        $comment_builder->setCommentStatus($result['comment_status']);
        $comment_builder->setParentThreadId($result['thread_id']);
        $comment_builder->setCommentCreatorUsername($result['username']);
        $comment_builder->setCommentCreatorFirstName($result['first_name']);
        $comment_builder->setCommentCreatorLastName($result['last_name']);
        $comment_builder->setCommentCreatorPhotoPath($result['photo_path']);
        $comment_builder->setCurrentUserVote($result['current_user_vote']);
        $comment_builder->setTotalLike($result['total_like']);
        $comment_builder->setTotalDislike($result['total_dislike']);
        $comment_builder->setCommentId($result['comment_id']);


        $builder->setChosenComment($comment_builder->build());
        return $builder;
    }



}