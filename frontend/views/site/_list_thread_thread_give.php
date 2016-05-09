<?php

/** @var $thread_id integer */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin(['action' =>['site/retrieve-comment-input'],
    'method' => 'post',
    'id' => 'retrieve_comment_input_' . $thread_id,
    'options' => [ 'data-pjax' => '#submit_comment_input_' . $thread_id]])

?>

    <?= Html::hiddenInput('thread_id', $thread_id) ?>


    <div class="col-xs-2" style="padding: 0; margin-right: 30px;">
        <button type="submit" data-service="<?= $thread_id?>" class="btn btn-default give_comment">Give Comment</button>
    </div>


<?php
    ActiveForm::end();
?>