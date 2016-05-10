<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use yii\widgets\Pjax;
    /** @var $comment_id integer */
    /** @var $child_comment_form \frontend\models\ChildCommentForm */
?>
<?php Pjax::begin([
    'timeout' => false,
    'id' => 'child_comment_input_box_'  . $comment_id,
    'enablePushState' => false,
    'clientOptions'=>[
        'container'=>'#child_comment_input_box_' . $comment_id,
    ]
]) ?>


<?php $form = ActiveForm::begin(['action' => ['thread/submit-child-comment'], 'id' => "child_comment_form_" . $comment_id,
    'options' =>[ 'data-pjax' => '#child_comment_input_box_' . $comment_id]]) ?>

    <?= Html::hiddenInput('user_id', \Yii::$app->getUser()->getId()) ?>
    <?= Html::hiddenInput('parent_id' , $comment_id) ?>
    <?= $form->field($child_comment_form, 'child_comment')->textarea(['class' => 'child_comment_text_area inline',
        'data-service' => $comment_id,
        'rows' => 1,
        'placeholder' => 'add comment box..' ])
        ->label(false)?>

    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary inline']) ?>

<?php ActiveForm::end() ?>

<?php Pjax::end()  ?>