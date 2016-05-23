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

?>

<div class="col-xs-12" style="padding-left: 0; padding-right: 0;">
    <!-- Retrieve comment input -->
    <?php

    $form1 = ActiveForm::begin(['action' =>['site/retrieve-comment-input'],
        'method' => 'post',
        'id' => 'retrieve_comment_input_box_form_' . $thread_id,
        'options' => [ 'data-pjax' => '#comment_input_' . $thread_id,
                    'class' => 'retrieve_comment_input_box_form']
    ]);

    ?>

        <?= Html::hiddenInput('thread_id', $thread_id) ?>

        <div class="col-xs-3 give-comment-button" style="padding: 0;">
            <?= Html::submitButton('Give Comment', ['class' => 'button-like-link give_comment',
                'data-service' => $thread_id]) ?>
        </div>

    <?php

    ActiveForm::end();

    ?>


    <!-- retrieve comment -->

    <div>
        <?= Html::a("Comment ( $thread_total_comments )",
                    $comment_request_url,
                    ['class' => 'button-like-link inline retrieve-comment-link',
                     'data-pjax' => "#comment_section_$thread_id",
                     'data-service' => $thread_id,
                     'style' => 'margin-left:15px; padding: 10px !important;'
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
<div style="margin-left: -15px; margin-right: -15px;">
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
