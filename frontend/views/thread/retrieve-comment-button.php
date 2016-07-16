<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    /** @var $thread \frontend\vo\ThreadVo */
    $thread_id = $thread->getThreadId();
    $current_user_has_vote = $thread->hasVote();
?>

<?php

$form1 = ActiveForm::begin(['action' =>['thread/retrieve-comment-input'],
    'method' => 'post',
    'id' => 'retrieve_comment_input_box_form_' . $thread_id,
    'options' => [ 'data-pjax' => '#comment_input_' . $thread_id,
        'class' => 'retrieve_comment_input_box_form']
]);

?>
    <?= Html::hiddenInput('thread_id', $thread_id) ?>
    <?= Html::submitButton('Give Comment',
                        ['class' => 'btn btn-sm btn-default give-comment inline',
                         'data-service' => $thread_id,
                         'disabled' => ($current_user_has_vote) ? false: true,
                         'id' => 'retrieve-input-box-button-' . $thread_id
                        ]) ?>
<?php
ActiveForm::end();
?>
