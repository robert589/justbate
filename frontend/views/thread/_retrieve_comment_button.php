<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    /** @var $thread \common\entity\ThreadEntity */
    $thread_id = $thread->getThreadId();
    $current_user_has_vote = $thread->hasVote();
?>

<?php

$form1 = ActiveForm::begin(['action' =>['site/retrieve-comment-input'],
    'method' => 'post',
    'id' => 'retrieve_comment_input_box_form_' . $thread_id,
    'options' => [ 'data-pjax' => '#comment_input_' . $thread_id,
        'class' => 'retrieve_comment_input_box_form']
]);

?>

<?= Html::hiddenInput('thread_id', $thread_id) ?>

<div class="col-xs-3 give-comment-button" style="position:absolute;padding: 0;margin-bottom: 2px">
    <?= Html::submitButton('Give Comment',
                        ['class' => 'btn btn-primary give-comment',
                         'data-service' => $thread_id,
                         'disabled' => ($current_user_has_vote) ? false: true,
                         'id' => 'retrieve-input-box-button-' . $thread_id
                        ]) ?>
</div>

<?php

ActiveForm::end();

?>