<?php
    use yii\helpers\Html;
    /** @var $thread \frontend\vo\ThreadVo */
    $comment_request_url = $thread->getCommentRequestUrl();
    $thread_id = $thread->getThreadId();
    $thread_total_comments = $thread->getTotalComments();
    $current_user_has_vote = $thread->hasVote();
    $current_user_anonymous = $thread->getCurrentUserAnonymous();
?>

    <div class="col-xs-12" style="padding-right: 0;">
        <div class="inline">
            <?= $this->render("../thread/retrieve-comment-button", ['thread' => $thread]) ?>
        </div>
        <div class="inline" style="margin-left: 5px">
            <?= \frontend\widgets\CommentInputAnonymous::widget(['anonymous' => $current_user_anonymous,
                'thread_id' => $thread_id ]) ?>
        </div>
    </div>

    <div  align="center" class="col-xs-12" >
        <?= Html::img(Yii::$app->request->baseUrl . '/frontend/web/img/loading.gif',
                    ['style' => 'display:none;max-height:50px' ,
                     'id' => 'list_thread_loading_gif_' . $thread_id ])
        ?>
    </div>
    <div style="margin-right: -15px;" class="col-xs-12">
            <?= $this->render('../thread/thread-comment-input-box',
                ['thread' => $thread,
                    'comment_model' => new \frontend\models\CommentForm()])
            ?>
    </div>