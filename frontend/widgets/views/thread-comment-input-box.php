<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
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
$current_user_anonymous = $thread->getCurrentUserAnonymous();

?>

<div class="thread-comment-input-box" id="<?= $id ?>">
     
    <?php $form = ActiveForm::begin(['action' => ['thread/submit-comment'],
                    'options' => ['class' => 'thread-comment-input-box-form',
                    'data-pjax' => '#comment_input_' . $thread_id]]) ?>
        <div class="thread-comment-input-box-user-info">
            <img class="thread-comment-input-box-user-info-image" 
                 src="<?= Yii::$app->getUser()->getIdentity()->getPhotoLink() ?>">
            <label class="thread-comment-input-box-user-info-name">
              <?= Yii::$app->getUser()->getIdentity()->getFullName() ?>
            </label>
        </div>
        <div class="thread-comment-input-box-comment-container" data-id="<?= $id ?>">
            <?= $form->field($comment_model,
                          'comment',
                          ['selectors' => ['input' => '#comment-input-' . $thread_id, 'data-id' => $id]])
                  ->widget(\yii\redactor\widgets\Redactor::className(),
                          ['options' => ['class' => 'thread-comment-input-box-comment', 
                                        'id' => 'thread-comment-input-box-comment-' . $thread_id],
                           'clientOptions' => [
                             'buttons' => Constant::defaultButtonRedactorConfig(),
                             'plugins' => Constant::defaultPluginRedactorConfig(),
                             'imageUpload' => \yii\helpers\Url::to(['/redactor/upload/image'])]])
                  ->label(false)?>

        </div>
        <div class="thread-comment-input-box-bottom">
            <?= Html::button('Submit', 
                    ['class' => 'btn thread-comment-input-box-button', 
                        'data-thread_id' => $thread_id, 'data-id' => $id, 'disabled' => ($comment_model->comment === null)]) ?>
        </div>
        <?= Html::hiddenInput('thread-comment-input-box-old-value', 
                $comment_model->comment, ['class' => 'thread-comment-input-box-old-value']) ?>
    <?php ActiveForm::end();?>
</div>