
<?php

use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

Pjax::begin([
    'id' => 'pjax_comment_' . $thread_id,
    'enablePushState' => 'false',
    'timeout' => false,
    'options' => [
        'container' => '#comment_section_' . $thread_id
    ]
]) ?>

<?php $form = ActiveForm::begin(['action' =>['site/get-comment'],'method' => 'post','id' => 'get_comment_form_' . $thread_id, 'options' => [ 'data-pjax' => '#comment_section_' . $thread_id]]  ) ?>
    <?= Html::hiddenInput('thread_id', $thread_id) ?>
    <?= Html::submitButton('Comment', ['class' => 'btn btn-default']) ?>
<?php ActiveForm::end() ?>

<div class="col-xs-12">

    <?php if(!empty($comment_retrieved)){ ?>
        <?= $this->render('../thread/_comment_part', ['comment_providers' => $comment_providers]) ?>
    <?php } ?>

</div>
<?php Pjax::end(); ?>


<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/frontend/web/js/jquery.js');
$this->registerJsFile(Yii::$app->request->baseUrl . '/frontend/web/js/site-_list_thread.js'); ?>
