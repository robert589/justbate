<?php
namespace frontend\dao;

use common\entity\ChildCommentVo;
use common\models\ChildComment;
use common\models\Notification;
use common\models\ThreadComment;
use frontend\vo\ChildCommentVoBuilder;
use frontend\vo\CommentVoBuilder;
use frontend\vo\ListNotificationVoBuilder;
use frontend\vo\NotificationVo;
use frontend\vo\NotificationVoBuilder;
use frontend\vo\ThreadCommentVoBuilder;

class CommentDao{
    const CHILD_COMMENT_INFO = "SELECT comment_info.*, thread_anonymous.thread_id is not null as anonymous
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
        SELECT comment.*, child_comment.parent_id, user.id, user.first_name, user.last_name, user.username, user.photo_path
                from child_comment
                inner join comment
                on child_comment.comment_id = comment.comment_id
                inner join user
                on user.id = comment.user_id
                where parent_id = :comment_id
                order by comment.created_at desc

    ";
    const THREAD_COMMENT_INFO = "SELECT comment_info.*, thread_anonymous.thread_id is not null as anonymous
                                from
                                    (SELECT comment.*, thread.title, thread.thread_id, user.id, user.username,  user.first_name, user.last_name,
                                       user.photo_path,
                                       COALESCE (count(case comment_vote.user_id when :user_id then vote else null end), 0 ) as vote,
                                       COALESCE (count(case vote when 1 then 1 else null end),0)as total_like,
                                       COALESCE (count(case vote when -1 then 1 else null end),0) as total_dislike
                                    from thread, user, comment, thread_comment, comment_vote
                                    where thread.thread_id = thread_comment.thread_id and thread_comment.comment_id = comment.comment_id
                                          and user.id = comment.user_id and comment.comment_id = :comment_id
                                          and comment.comment_status = 10 and comment_vote.comment_id = comment.comment_id) comment_info
                                left join thread_anonymous
                                on thread_anonymous.thread_id = comment_info.thread_id and thread_anonymous.user_id = comment_info.user_id";

    const CHILD_COMMENT_EXIST_SQL = "SELECT count(*) from thread_comment, child_comment, thread
                                    where thread_comment.thread_id = :thread_id and thread_comment.comment_id = comment.parent_id
                                    and comment.comment_id = :comment_id LIMIT 1";

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
            $builder = $this->buildChildCommentList($comment_id, $builder);
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
        $builder->setCurrentUserVote($result['vote']);
        $builder->setTotalLike($result['total_like']);
        $builder->setTotalDislike($result['total_dislike']);
        $builder->setCommentId($result['comment_id']);
        return $builder;

    }

    private function buildChildCommentList($comment_id, ThreadCommentVoBuilder $builder){
        $results =  \Yii::$app->db
            ->createCommand(self::THREAD_COMMENT_CHILD_COMMENT)
            ->bindValues([':comment_id' => $comment_id])
            ->queryAll();

        $child_comment_list = array();

        foreach($results as $result){
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

            $child_comment_list[] = $child_comment_builder->build();
        }

        $builder->setChildCommentList($child_comment_list);
        return $builder;


    }


}