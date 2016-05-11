<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use yii\widgets\Pjax;
    /** @var $comment_id integer */
    /** @var $child_comment_form \frontend\models\ChildCommentForm */
?>
<?php Pjax::begin([
    'id' => 'child_comment_input_box_'  . $comment_id . uniqid(),
    'enableReplaceState' => false,
    'enablePushState' => false,
    'timeout' => 100000,
    'clientOptions'=>[
        'container'=>'#child_comment_input_box_' . $comment_id,
        'data-service' => $comment_id,
        'class' => 'child_comment_input_box_pjax',
    ]
]) ?>


<?php $form = ActiveForm::begin(['action' => ['thread/submit-child-comment'],
                                             'enableAjaxValidation' => false,
                                            'options' =>[ 'data-pjax' => '#child_comment_input_box_' . $comment_id,
                                            'class' => 'submit_child_comment_form']]) ?>

    <?= Html::hiddenInput('user_id', \Yii::$app->getUser()->getId()) ?>
    <?= Html::hiddenInput('parent_id' , $comment_id) ?>

    <?= $form->field($child_comment_form, 'child_comment')->textarea(['class' => 'inline',
        'data-service' => $comment_id,
        'rows' => 1,
        'placeholder' => 'add comment box..' ])
        ->label(false)?>

    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary inline ', 'data-pjax' => 0
                               ]) ?>

<?php ActiveForm::end() ?>

<?php Pjax::end()  ?>