<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use yii\widgets\Pjax;
    /** @var $comment_id integer */
    /** @var $child_comment_form \frontend\models\ChildCommentForm */
?>
<?php Pjax::begin([
    'id' => 'child_comment_input_box_'  . $comment_id ,
    'enablePushState' => false,
    'timeout' => false,
    'clientOptions'=>[

        'container'=>'#child_comment_input_box_' . $comment_id,
        'data-service' => $comment_id,
        'class' => 'child_comment_input_box_pjax',
    ]
]) ?>


<?php $form = ActiveForm::begin(['action' => ['thread/submit-child-comment'],
                                            'id' => 'submit_child_comment_form_' . $comment_id,
                                            'options' =>[ 'data-pjax' => '#child_comment_input_box_' . $comment_id,
                                                            'class' => 'submit_child_comment_form',
                                                            'data-service' => $comment_id]
                                ])
?>

    <?= Html::hiddenInput('user_id', \Yii::$app->getUser()->getId()) ?>
    <?= Html::hiddenInput('parent_id' , $comment_id) ?>

    <?= $form->field($child_comment_form, 'child_comment')->textarea(['class' => 'inline',
        'data-service' => $comment_id,
        'rows' => 1,
        'placeholder' => 'add comment box..' ])
        ->label(false)?>

    <?= Html::submitButton('Submit', ['class' => 'btn btn- inline submit-child-comment-form-button',
        'data-service' => $comment_id,'id' => 'submit-child-comment-form-button-'  . $comment_id
    ]) ?>

<?php ActiveForm::end() ?>

<?php Pjax::end()  ?>
