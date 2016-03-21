<?php

use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var $thread_id integer */
/** @var $comment_providers \yii\data\ArrayDataProvider */
Pjax::begin([
    'id' => 'pjax_comment_' . $thread_id,
    'enablePushState' => false,
    'timeout' => false,
    'options' => [
        'container' => '#comment_section_' . $thread_id
    ]
])
?>


    <?php
    if(empty($comment_retrieved)){
        $form = ActiveForm::begin(['action' =>['site/get-comment'],
                                    'method' => 'post',
                                    'id' => 'get_comment_form_' . $thread_id,
                                    'options' => [ 'data-pjax' => '#comment_section_' . $thread_id]]  ) ?>

        <?= Html::hiddenInput('thread_id', $thread_id) ?>
        <?= Html::submitButton('Comment', ['class' => 'btn btn-primary', 'id' => 'comment_post']) ?>

    <?php ActiveForm::end();
    }
    else{ ?>
        <?= Html::button('Hide', ['class' => 'btn btn-primary', 'id' => 'home_comment', 'data-services' => $thread_id]) ?>
        <div class="comment-tab section">
            <?= $this->render('../thread/_comment_part', ['comment_providers' => $comment_providers]) ?>
        </div>
    <?php } ?>

<?php Pjax::end(); ?>