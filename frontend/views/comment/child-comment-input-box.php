<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
/** @var $comment_id integer */
/** @var $child_comment_form \frontend\models\ChildCommentForm */
?>
<?php
/**
 * Used Variable
 */
$last_comment_id_current_user = isset($last_comment_id_current_user) ? $last_comment_id_current_user : null;
?>

<?php $form = ActiveForm::begin(
    ['action' => ['comment/submit-child-comment'],
     'id' => 'submit_child_comment_form_' . $comment_id,
     'options' =>
        [
            'data-pjax' => 0,
            'data-service' => $comment_id,
            'class' => 'submit_child_comment_form'
        ]
])
?>
    <?= Html::hiddenInput('last_comment_id_current_user',
        $last_comment_id_current_user,
        ['id' => 'last_comment_id_current_user_' . $comment_id])?>
    <?= Html::hiddenInput('user_id', \Yii::$app->getUser()->getId(), ['id' => 'current_user_login_id_' . $comment_id]) ?>
    <?= Html::hiddenInput('parent_id' , $comment_id, ['id' => 'child-comment-input-box-' . $comment_id]) ?>
    <div class="col-xs-12">
        <div class="col-xs-12">
            <?= $form->field($child_comment_form, 'child_comment')->textarea([
                'data-service' => $comment_id,
                'rows' => 3,
                'cols' => 3,
                'style' => 'width:100%',
                'placeholder' => 'add comment here..' ])
                ->label(false)?>
        </div>
        <div class="col-xs-offset-6 col-xs-6">
            <?= Html::submitButton('Submit',
                ['class' => 'btn btn-sm submit-child-comment-form-button',
                    'style' => 'float:left',
                    'data-service' => $comment_id,
                    'id' => 'submit-child-comment-form-button-'  . $comment_id
                ]) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>
