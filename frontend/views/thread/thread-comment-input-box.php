<?php
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\components\Constant;
/* @var $thread \frontend\vo\ThreadVo **/
/* @var $comment_model \frontend\models\CommentForm */
/** @var $comment_input_retrieved boolean */
/**
 * Variable Used
 */
$thread_id = $thread->getThreadId();
$current_user_choice = $thread->getCurrentUserVote();
$comment_model->choice_text = $current_user_choice;
Pjax::begin([
    'id' => 'comment_input_' . $thread_id,
    'enablePushState' => false,
    'timeout' => false,
    'options' => [
        'class' => 'comment_input_pjax',
        'data-service' => $thread_id,
        'container' => '#comment_input_' . $thread_id
    ]
]);




if(isset($comment_input_retrieved)) {

?>

    <?php
    $current_user_anonymous = $thread->getCurrentUserAnonymous();
    $form = ActiveForm::begin(['action' => ['thread/submit-comment'],
                    'options' => ['class' => 'comment-form',
                    'data-pjax' => '#comment_input_' . $thread_id]]) ?>

        <div class="row" id="comment_input_box_section_<?= $thread_id ?>">
            <hr>
            <div class="col-xs-12" id="redactor_box_<?= $thread_id ?>" style="padding-top: 8px">
                <?= $form->field($comment_model,
                                  'comment',
                                  ['selectors' => ['input' => '#comment-input-' . $thread_id]])
                          ->widget(\yii\redactor\widgets\Redactor::className(),
                                  ['options' => ['id' => 'comment-input-' . $thread_id],
                                   'clientOptions' => [
                                     'buttons' => Constant::defaultButtonRedactorConfig(),
                                     'plugins' => Constant::defaultPluginRedactorConfig(),
                                     'imageUpload' => \yii\helpers\Url::to(['/redactor/upload/image'])]])
                          ->label(false)?>
            </div>
            <div class="row">
                <div class="col-xs-6" align="center">
                    <b>You chose for </b>
                    <div id="choice-text-comment-input-box-<?= $thread_id ?>" >
                        <?= $comment_model->choice_text ?>
                    </div>
                    <?= $form->field($comment_model, 'choice_text')->hiddenInput(['value' => $thread->getCurrentUserVote()])->label(false) ?>
                </div>
                <div align="right" class="col-xs-6">
                    <?= Html::hiddenInput('thread_id', $thread_id) ?>
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'style' => 'width: 100%;']) ?>
                </div>
            </div>
            <hr>
        </div>

    <?php ActiveForm::end();
}

Pjax::end() ;

?>