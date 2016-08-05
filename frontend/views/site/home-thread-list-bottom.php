<?php
    use yii\helpers\Html;
    use frontend\widgets\CommentInputAnonymous;
    /** @var $thread \frontend\vo\ThreadVo */
    $comment_request_url = $thread->getCommentRequestUrl();
    $thread_id = $thread->getThreadId();
    $thread_total_comments = $thread->getTotalComments();
    $current_user_has_vote = $thread->hasVote();
    $current_user_anonymous = $thread->getCurrentUserAnonymous();
?>

    <div class="inline">
        <?= $this->render("../thread/retrieve-comment-button", ['thread' => $thread]) ?>
    </div>
    <div class="inline" style="margin-left: 5px">
        <?= CommentInputAnonymous::widget(['anonymous' => $current_user_anonymous,
            'thread_id' => $thread_id ]) ?>
    </div>


    <?= Html::img(Yii::$app->request->baseUrl . '/frontend/web/img/loading.gif',
                ['style' => 'display:none;max-height:50px' ,
                 'id' => 'list_thread_loading_gif_' . $thread_id ])
    ?>

    <?= $this->render('../thread/thread-comment-input-box',
        ['thread' => $thread,
        'comment_model' => new \frontend\models\CommentForm()])?>    