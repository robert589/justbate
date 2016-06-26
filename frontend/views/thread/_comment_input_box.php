<?php
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\components\Constant;
/* @var $thread \common\entity\ThreadEntity **/
/* @var $comment_model \frontend\models\CommentForm */
/** @var $comment_input_retrieved boolean */
/**
 * Variable Used
 */
$thread_id = $thread->getThreadId();
$thread_choices = $thread->getChoices();
$current_user_choice = $thread->getCurrentUserChoice();
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
    //prepare data
    $choice_text = array();
    foreach ($thread_choices as $choice) {
        $choice_text[$choice['choice_text']] = $choice['choice_text'];
    }
?>

    <?php
    $current_user_anonymous = $thread->getCurrentUserAnonymous();
    $form = ActiveForm::begin(['action' => ['thread/submit-comment'],
                    'options' => ['class' => 'comment-form',
                    'data-pjax' => '#comment_input_' . $thread_id]]) ?>

        <div class="col-xs-12" id="comment_input_box_section_<?= $thread_id ?>" style="padding: 0;">
            <hr>
            <div class="col-xs-12">
                <?= \frontend\widgets\CommentInputAnonymous::widget(['anonymous' => $current_user_anonymous,
                                                                     'thread_id' => $thread_id ]) ?>
            </div>
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
                    <?= $form->field($comment_model, 'choice_text')->hiddenInput(['value' => $thread->getCurrentUserChoice()])->label(false) ?>
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