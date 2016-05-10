<?php

use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var $thread_id integer */
/** @var $total_comments integer */
/** @var $comment_providers \yii\data\ArrayDataProvider */
/** @var $thread_choice_text array */
/** @var $user_choice_text string */
?>
<div class="col-xs-12" style="padding-left: 0; padding-right: 0;">

<!-- Retrieve comment input -->


<?php
$form1 = ActiveForm::begin(['action' =>['site/retrieve-comment-input'],
    'method' => 'post',
    'id' => 'retrieve_comment_input_box_form_' . $thread_id,
    'options' => [ 'data-pjax' => '#comment_input_' . $thread_id]]);
?>

    <?= Html::hiddenInput('thread_id', $thread_id) ?>

    <div class="col-xs-2" style="padding: 0; margin-right: 30px;">
        <?= Html::submitButton('Give Comment', ['class' => 'btn btn-default give_comment',
            'data-service' => $thread_id]) ?>
    </div>

<?php  ActiveForm::end();  ?>

    <!-- Voting -->
<?= $this->render('_list_thread_thread_vote', ['thread_choice_text' => $thread_choice_text, 'user_choice_text' => $user_choice_text, 'thread_id' => $thread_id]) ?>

    <!-- retrieve comment -->
<?php
    $form = ActiveForm::begin(['action' =>['site/get-comment'],
    'method' => 'get',
    'id' => 'retrieve_comment_form_' . $thread_id,
    'options' => [ 'data-pjax' => '#comment_section_' . $thread_id]]);
?>

    <?= Html::hiddenInput('thread_id', $thread_id) ?>

    <?= Html::button('Comment (' . $total_comments . ')',
        ['class' => 'btn btn-primary inline retrieve-comment-btn',
            'data-service' => $thread_id,
            'style' => 'margin-left:15px' ]) ?>

<?php ActiveForm::end(); ?>

</div>

<!-- Comment input box-->
<div style="margin-left: -15px; margin-right: -15px;">
    <?= $this->render('../thread/_comment_input_box', ['thread_choices' => $thread_choice_text,
                                            'thread_id' => $thread_id,
                                            'commentModel' => new \frontend\models\CommentForm()])?>
</div>

<!-- Thread comment -->
<div class="col-xs-12" style="width: 100%">
    <?= $this->render('_list_thread_thread_comment', ['total_comments' => $total_comments,
                                                    'thread_id' => $thread_id]) ?>
</div>
