<?php

use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

Pjax::begin([
    'id' => 'pjax_comment_' . $thread_id,
    'enablePushState' => false,
    'timeout' => false,
    'options' => [
        'container' => '#comment_section_' . $thread_id
    ]
    ]) ?>


    <div class="col-xs-6" id="comment-part-home">
    <?php
    if(empty($comment_retrieved)){
        $form = ActiveForm::begin(['action' =>['site/get-comment'],'method' => 'post','id' => 'get_comment_form_' . $thread_id, 'options' => [ 'data-pjax' => '#comment_section_' . $thread_id]]  ) ?>

        <?= Html::hiddenInput('thread_id', $thread_id) ?>
        <?= Html::submitButton('Comment', ['class' => 'btn btn-primary', 'id' => 'comment_post']) ?>
        <?php
        ActiveForm::end();
    } else{ ?>
        <?= Html::button('Hide', ['class' => 'btn btn-primary', 'id' => 'comment_post']) ?>
        <div id="list_thread_comment_part">
            <?= $this->render('../thread/_comment_part', ['comment_providers' => $comment_providers]) ?>
        </div>
        <?php } ?>
    </div>
    <div class="col-xs-6" id="vote-part-home">
        <select class="form-control">
            <option>-- Choose one of these vote --</option>
            <option>Agree</option>
            <option>Disagree</option>
            <option>Neutral</option>
            <option>Custom ...</option>
        </select>
    </div>
    <?php Pjax::end(); ?>
