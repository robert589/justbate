<?php
use yii\widgets\ActiveForm;
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
$comment_model->comment = $thread->getCurrentUserComment();
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
        
        <div class="col-xs-12 thread-comment-input-box-section" id="comment_input_box_section_<?= $thread_id ?>">
            <div class="row" style="padding-top:10px;padding-left:4px">
                <span>
                    <img class="img img-circle profile-picture-comment" style="width: 40px;height:40px;background:white" 
                         src="<?= Yii::$app->getUser()->getIdentity()->getPhotoLink() ?>">
                        </span>
                <span>
                    <label>
                          <?= Yii::$app->getUser()->getIdentity()->getFullName() ?>
                    </label>
                </span>
            </div>
            <div class="row thread-comment-redactor-box" id="redactor_box_<?= $thread_id ?>">
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
            
            <div class="row" align="right">
                <?= Html::hiddenInput('thread_id', $thread_id) ?>
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end();
}

Pjax::end() ;

?>