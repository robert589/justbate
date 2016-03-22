<?php

use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var $thread_id integer */
/** @var $total_comment integer */

/** @var $comment_providers \yii\data\ArrayDataProvider */
Pjax::begin([
    'id' => 'comment_section_' . $thread_id,
    'enablePushState' => false,
    'timeout' => 6000,
    'options' => [
        'container' => '#comment_section_' . $thread_id
    ]
])
?>


    <?php
    if(empty($comment_retrieved)){
        /*Html::beginForm(['site/get-comment'],
                        'post',
                        ['id' => 'get_comment_form_' . $thread_id,
                            'data-pjax' => '#comment_section_' . $thread_id]
        );*/

        $form = ActiveForm::begin(['action' =>['site/get-comment'],
                                  'method' => 'post',
                                'id' => 'get_comment_form_' . $thread_id,
                              'options' => [ 'data-pjax' => '#comment_section_' . $thread_id]])  ?>

        <?= Html::hiddenInput('thread_id', $thread_id) ?>
        <?= Html::submitButton('Comment (' . $total_comments . ')', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end();
    }
    else{ ?>
        <?= Html::button('Hide', ['class' => 'btn btn-primary', 'id' => 'home_comment', 'data-services' => $thread_id]) ?>
        <div class="comment-tab section">
            <?= $this->render('../thread/_comment_part', ['comment_providers' => $comment_providers]) ?>
        </div>
    <?php } ?>

<?php Pjax::end(); ?>