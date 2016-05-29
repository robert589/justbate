<?php

use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var $thread \common\entity\ThreadEntity */

/**
 * Used variable
 */

$comment_request_url = $thread->getCommentRequestUrl();
$thread_id = $thread->getThreadId();
$thread_total_comments = $thread->getTotalComment();
$current_user_has_vote = $thread->hasVote();
?>

<div class="col-xs-12" style="padding-left: 0; padding-right: 0;">
    <!-- Retrieve comment input -->
    <?= $this->render('../thread/_retrieve_comment_button', ['thread' => $thread]) ?>

    <!-- retrieve comment -->

    <div>
        <?= Html::a("Comment ( $thread_total_comments )",
                    $comment_request_url,
                    ['class' => 'button-like-link inline retrieve-comment-link',
                     'data-pjax' => "#comment_section_$thread_id",
                     'data-service' => $thread_id,
                     'style' => 'margin-left:105pt;position:relative; padding: 10px !important;'
                    ])
        ?>
    </div>
</div>

<div  align="center" class="col-xs-12" >
    <?= Html::img(Yii::$app->request->baseUrl . '/frontend/web/img/loading.gif',
                ['style' => 'display:none;max-height:50px' ,
                 'id' => 'list_thread_loading_gif_' . $thread_id ])
    ?>
</div>

<!-- Comment input box-->
<div style="margin-right: -15px;">
    <?= $this->render('../thread/_comment_input_box',
                        ['thread' => $thread,
                         'comment_model' => new \frontend\models\CommentForm()])
    ?>
</div>

<!-- Thread comment -->
<div class="col-xs-12" style="width: 100%">
    <?= $this->render('_list_thread_thread_comment',
                    ['thread' => $thread  ])
    ?>
</div>
