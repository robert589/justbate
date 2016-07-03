<?php

use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var $thread \frontend\vo\ThreadVo */

/**
 * Used variable
 */
$comment_request_url = $thread->getCommentRequestUrl();
$thread_id = $thread->getThreadId();
$thread_total_comments = $thread->getTotalComments();
$current_user_has_vote = $thread->hasVote();
?>

<div class="col-xs-12" style="padding-right: 0;">
    <div class="inline">
        <?= $this->render('../thread/_retrieve_comment_button', ['thread' => $thread]) ?>
    </div>
</div>

<div  align="center" class="col-xs-12" >
    <?= Html::img(Yii::$app->request->baseUrl . '/frontend/web/img/loading.gif',
                ['style' => 'display:none;max-height:50px' ,
                 'id' => 'list_thread_loading_gif_' . $thread_id ])
    ?>
</div>
<!-- Comment input box-->
<div style="margin-right: -15px;" class="col-xs-12">
    <?= $this->render('../thread/_comment_input_box',
                        ['thread' => $thread,
                         'comment_model' => new \frontend\models\CommentForm()])
    ?>
</div>
