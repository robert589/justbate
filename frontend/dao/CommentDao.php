<?php
namespace frontend\dao;

use common\entity\ChildCommentVo;
use common\models\Notification;
use common\models\ThreadComment;
use frontend\vo\ChildCommentVoBuilder;
use frontend\vo\CommentVoBuilder;
use frontend\vo\ListNotificationVoBuilder;
use frontend\vo\NotificationVo;
use frontend\vo\NotificationVoBuilder;
use frontend\vo\ThreadCommentVoBuilder;

class CommentDao{
    const COMMENT_INFO = "";

    const CHILD_COMMENT_EXIST_SQL = "SELECT count(*) from thread_comment, child_comment, thread
                                    where thread_comment.thread_id = :thread_id and thread_comment.comment_id = comment.parent_id
                                    and comment.comment_id = :comment_id";

    function buildChildComment($user_id, $thread_id, $comment_id, ChildCommentVoBuilder $builder){



    }


    function buildThreadComment($user_id, $thread_id, $comment_id, ThreadCommentVoBuilder $builder){

    }


    private function checkThreadCommentExist($thread_id, $comment_id){
        return ThreadComment::find()->where(['thread_id' => $thread_id, 'comment_id' => $comment_id])->exists();
    }

    private function checkChildCommentExist($thread_id, $comment_id){

    }
}