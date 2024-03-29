<?php
namespace frontend\dao;

use common\models\ChildComment;
use common\models\ThreadComment;
use frontend\vo\ChildCommentVoBuilder;
use frontend\vo\ThreadCommentVoBuilder;

class CommentDao{

        const GET_ONE_CHILD_COMMENT = "
        SELECT comment_info.*, thread_anonymous.anonymous_id as anonymous,
            CASE when (user_vote.comment_id is not null) then user_vote.vote else null end as current_user_vote,
            count(case when total_vote.vote = 1 then 1 else null end) as total_like,
            count(case when total_vote.vote = -1 then 1 else null end) as total_dislike  
        from (
                SELECT comment.*, child_comment.parent_id as parent_id, thread_comment.thread_id as thread_id,
                   user.username, user.first_name, user.last_name, user.photo_path, user.id
                from comment, child_comment, user, thread_comment
                where child_comment.parent_id = :comment_id and 
                          child_comment.comment_id = comment.comment_id 
                          and comment.user_id = user.id and
                 thread_comment.comment_id = child_comment.parent_id
            order by comment.created_at desc limit 1 ) comment_info

        left join thread_anonymous
        on thread_anonymous.thread_id = comment_info.thread_id and comment_info.user_id =  thread_anonymous.user_id
        left join comment_vote user_vote
        on comment_info.comment_id = user_vote.comment_id and user_vote.user_id = :user_id
        left join comment_vote total_vote
        on total_vote.comment_id  = comment_info.comment_id
        group by comment_info.comment_id
    ";

    const GET_EXISTING_THREAD_COMMENT_ID = "SELECT comment.comment_id 
                                            from comment inner join thread_comment
                                        on thread_comment.comment_id = comment.comment_id
                                        where thread_comment.thread_id = :thread_id and comment.user_id = :user_id and comment.comment_status = 10
                                        order by comment.created_at desc
                                        limit 1;";
    
    const CHILD_COMMENT_INFO = "SELECT comment_info.*, thread_anonymous.anonymous_id as anonymous
                                from (
                                    SELECT child_comment_info.*, creator.first_name, creator.last_name, creator.photo_path, creator.username, thread_of_parent_comment.thread_id,
                                       COALESCE (count(case comment_vote.user_id when :user_id then vote else null end), 0 ) as vote,
                                       COALESCE (count(case vote when 1 then 1 else null end),0)as total_like,
                                       COALESCE (count(case vote when -1 then 1 else null end),0) as total_dislike
                                    from comment child_comment_info, child_comment, comment parent_comment, user creator, thread thread_of_parent_comment, comment_vote, thread_comment
                                    where child_comment_info.comment_id = child_comment.comment_id and
                                            parent_comment.comment_id = thread_comment.comment_id and
                                            thread_of_parent_comment.thread_id = thread_comment.thread_id and
                                            child_comment_info.user_id = creator.id and
                                            child_comment.parent_id = parent_comment.comment_id and
                                            child_comment.comment_id = :comment_id and
                                            comment_vote.comment_id = :comment_id ) comment_info
                                left join thread_anonymous
                                on comment_info.thread_id = thread_anonymous.thread_id

        ";

    const THREAD_COMMENT_CHILD_COMMENT = "
                SELECT comment_list.*, thread_comment.thread_id,
                        thread_anonymous.anonymous_id as anonymous,
                         (case comment_vote.user_id when :user_id then vote else null end) as current_user_vote,
                         COALESCE (count(case vote when 1 then 1 else null end),0)as total_like,
                         COALESCE (count(case vote when -1 then 1 else null end),0) as total_dislike

                FROM (
                        SELECT comment.*, child_comment.parent_id, user.id, user.first_name, user.last_name, user.username, user.photo_path
                        from child_comment
                        inner join comment
                        on child_comment.comment_id = comment.comment_id
                        inner join user
                        on user.id = comment.user_id
                        where parent_id = :parent_id and comment.created_at < :last_time) comment_list
                inner join thread_comment
                on thread_comment.comment_id = comment_list.parent_id
                left join thread_anonymous
                on thread_anonymous.user_id = comment_list.user_id and thread_anonymous.thread_id = thread_comment.thread_id
                left join comment_vote
                on comment_vote.comment_id = comment_list.comment_id
                group by (comment_list.comment_id)
                order by comment_list.created_at desc
                limit :limit

    ";
    const THREAD_COMMENT_INFO = "SELECT comment_info.*, thread_anonymous.anonymous_id as anonymous, thread_vote.choice_text, count(child_comment.comment_id) as total_comment
                                from
                                    (SELECT comment.*, thread.title, thread.thread_id, user.id, user.username,  user.first_name, user.last_name,
                                       user.photo_path,
                                       COALESCE (count(case comment_vote.user_id when :user_id then vote else null end), 0 ) as current_user_vote,
                                       COALESCE (count(case vote when 1 then 1 else null end),0)as total_like,
                                       COALESCE (count(case vote when -1 then 1 else null end),0) as total_dislike
                                     from thread, user, comment, thread_comment, comment_vote
                                     where thread.thread_id = thread_comment.thread_id and thread_comment.comment_id = comment.comment_id
                                          and user.id = comment.user_id and comment.comment_id = :comment_id
                                          and comment.comment_status = 10 and comment_vote.comment_id = comment.comment_id) comment_info
                                left join thread_vote
                                on thread_vote.thread_id = comment_info.thread_id and comment_info.user_id = thread_vote.user_id
                                left join thread_anonymous
                                 on thread_anonymous.thread_id = comment_info.thread_id and thread_anonymous.user_id = comment_info.user_id
                                left join child_comment
                                on  child_comment.parent_id = comment_info.comment_id";

    const CHILD_COMMENT_EXIST_SQL = "SELECT count(*) from thread_comment, child_comment, thread
                                    where thread_comment.thread_id = :thread_id and thread_comment.comment_id = comment.parent_id
                                    and comment.comment_id = :comment_id LIMIT 1";
    
    const GET_TOTAL_COMMENT = "SELECT count(*) as total_comment from child_comment where child_comment.parent_id = :comment_id";

    
    function getTotalComment($comment_id) {
        return (int) \Yii::$app->db
                ->createCommand(self::GET_TOTAL_COMMENT)
                ->bindValues([':comment_id' => $comment_id])

                ->queryScalar();
        
    }
    
    function buildChildComment($user_id, $comment_id, ChildCommentVoBuilder $builder){
        if($this->checkChildCommentExist($comment_id)){
            $result =  \Yii::$app->db
                ->createCommand(self::CHILD_COMMENT_INFO)
                ->bindValues([':comment_id' => $comment_id])
                ->bindValues([':user_id' => $user_id])

                ->queryOne();

            $builder->setAnonymous($result['anonymous']);
            $builder->setCommentCreatorId($result['user_id']);
            $builder->setCreatedAt($result['created_at']);
            $builder->setComment($result['comment']);
            $builder->setUpdatedAt($result['updated_at']);
            $builder->setCommentStatus($result['comment_status']);
            $builder->setCommentCreatorUsername($result['username']);
            $builder->setCommentCreatorFirstName($result['first_name']);
            $builder->setCommentCreatorLastName($result['last_name']);
            $builder->setCommentCreatorPhotoPath($result['photo_path']);
            $builder->setCurrentUserVote($result['vote']);
            $builder->setTotalLike($result['total_like']);
            $builder->setTotalDislike($result['total_dislike']);
            $builder->setCommentId($result['comment_id']);
            return $builder;

        }
        return null;
    }


    function buildThreadComment($user_id, $thread_id, $comment_id, ThreadCommentVoBuilder $builder){
        if($this->checkThreadCommentExist($thread_id, $comment_id)) {
            $builder = $this->buildThreadCommentInfo($user_id, $comment_id, $builder);
            return $builder;
        }
        return null;
    }


    private function checkThreadCommentExist($thread_id, $comment_id){

        $result =  ThreadComment::find()->where(['thread_id' => $thread_id, 'comment_id' => $comment_id])->exists();

        return $result;
    }

    private function checkChildCommentExist($comment_id){
        return ChildComment::find()->where(['comment_id' => $comment_id])->exists();
    }

    private function buildThreadCommentInfo($user_id, $comment_id, ThreadCommentVoBuilder $builder){
        $result =  \Yii::$app->db
            ->createCommand(self::THREAD_COMMENT_INFO)
            ->bindValues([':user_id' => $user_id])
            ->bindValues([':comment_id' => $comment_id])
            ->queryOne();
        $builder->setAnonymous($result['anonymous']);
        $builder->setCommentCreatorId($result['user_id']);
        $builder->setCreatedAt($result['created_at']);
        $builder->setComment($result['comment']);
        $builder->setUpdatedAt($result['updated_at']);
        $builder->setCommentStatus($result['comment_status']);
        $builder->setParentThreadTitle($result['title']);
        $builder->setParentThreadId($result['thread_id']);
        $builder->setCommentCreatorUsername($result['username']);
        $builder->setCommentCreatorFirstName($result['first_name']);
        $builder->setCommentCreatorLastName($result['last_name']);
        $builder->setCommentCreatorPhotoPath($result['photo_path']);
        $builder->setCurrentUserVote($result['current_user_vote']);
        $builder->setTotalLike($result['total_like']);
        $builder->setTotalDislike($result['total_dislike']);
        $builder->setCommentId($result['comment_id']);
        $builder->setChoiceText($result['choice_text']);
        // $builder->setTotalComment($this->getTotalComment($result['comment_id'], $builder));
        $builder->setTotalComment($result['total_comment']);
        $builder->setChosenComment($this->getOneChildComment($comment_id, $user_id)->build());
        return $builder;

    }

  
    /**
     * @param $comment_id
     * @param $current_user_id
     * @param $perPage
     * @param $pageSize
     * @return ThreadCommentVoBuilder
     * Ajax request
     */
    public function buildNextChildCommentList($comment_id, $user_id, $last_time, $limit) {
        $results =  \Yii::$app->db
            ->createCommand(self::THREAD_COMMENT_CHILD_COMMENT)
            ->bindValues([':parent_id' => $comment_id])
            ->bindValues([':user_id' => $user_id])
            ->bindValue(':last_time', (int) $last_time)
            ->bindValue(':limit', (int) $limit)
            ->queryAll();
        $child_comment_list = array();
        foreach( $results as $result) {
            $child_comment_builder = new ChildCommentVoBuilder();
            $child_comment_builder->setCommentId($result['comment_id']);
            $child_comment_builder->setParentId($result['parent_id']);
            $child_comment_builder->setCommentCreatorId($result['user_id']);
            $child_comment_builder->setCreatedAt($result['created_at']);
            $child_comment_builder->setComment($result['comment']);
            $child_comment_builder->setUpdatedAt($result['updated_at']);
            $child_comment_builder->setCommentStatus($result['comment_status']);
            $child_comment_builder->setCommentCreatorFirstName($result['first_name']);
            $child_comment_builder->setCommentCreatorLastName($result['last_name']);
            $child_comment_builder->setCommentCreatorUsername($result['username']);
            $child_comment_builder->setCommentCreatorPhotoPath($result['photo_path']);
            $child_comment_builder->setAnonymous($result['anonymous']);
            $child_comment_builder->setTotalLike($result['total_like']);
            $child_comment_builder->setTotalDislike($result['total_dislike']);
            $child_comment_builder->setCurrentUserVote($result['current_user_vote']);
            $child_comment_list[] = $child_comment_builder->build();
        }
        return $child_comment_list;

    }
    
    public function getExistingCommentId($thread_id, $user_id) {
        $result =  \Yii::$app->db
            ->createCommand(self::GET_EXISTING_THREAD_COMMENT_ID)
            ->bindValues([':thread_id' => $thread_id])
            ->bindValues([':user_id' => $user_id])
            ->queryScalar();
        
        if($result === null) {
            return null;
        } else {
            return $result;
        }
    }

        
    public function getOneChildComment($comment_id, $user_id) {
        $result_of_chosen_comment = \Yii::$app->db
                ->createCommand(self::GET_ONE_CHILD_COMMENT)
                ->bindValue(':comment_id', $comment_id)
                ->bindValue(':user_id', $user_id)
                ->queryOne();
                
        $child_comment_builder = new ChildCommentVoBuilder();
        $child_comment_builder->setCommentId($result_of_chosen_comment['comment_id']);
        $child_comment_builder->setCommentCreatorId($result_of_chosen_comment['user_id']);
        $child_comment_builder->setCommentCreatorUsername($result_of_chosen_comment['username']);
        $child_comment_builder->setCommentCreatorFirstName($result_of_chosen_comment['first_name']);
        $child_comment_builder->setCommentCreatorLastName($result_of_chosen_comment['last_name']);
        $child_comment_builder->setCommentStatus($result_of_chosen_comment['comment_status']);
        $child_comment_builder->setCreatedAt($result_of_chosen_comment['created_at']);
        $child_comment_builder->setUpdatedAt($result_of_chosen_comment['updated_at']);
        $child_comment_builder->setComment($result_of_chosen_comment['comment']);
        $child_comment_builder->setParentId($result_of_chosen_comment['parent_id']);
        $child_comment_builder->setCommentCreatorPhotoPath($result_of_chosen_comment['photo_path']);
        $child_comment_builder->setTotalLike($result_of_chosen_comment['total_like']);
        $child_comment_builder->setTotalDislike($result_of_chosen_comment['total_dislike']);
        $child_comment_builder->setCurrentUserVote($result_of_chosen_comment['current_user_vote']);
        $child_comment_builder->setAnonymous($result_of_chosen_comment['anonymous']);
        return $child_comment_builder;
    }


}