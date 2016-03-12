<?php
    use yii\widgets\ActiveForm;
    use kartik\widgets\Select2;
    use yii\helpers\Html;
?>


<!--Comment Input Part-->
<?php $form =ActiveForm::begin(['action' => ['thread/submit-comment'], 'id' => 'comment-form']) ?>

<div align="center">
    <h3>Give your comment</h3>
</div>

<div class="col-xs-12">
    <div class="row">
        <div class="col-xs-12">

            <?= $form->field($commentModel, 'comment')->widget(\yii\redactor\widgets\Redactor::className(),
                [
                    'clientOptions' => [
                        'imageUpload' => \yii\helpers\Url::to(['/redactor/upload/image']),
                    ],

                ])->label(false) ?>
        </div>

    </div>
    <div class="row">
        <div class="col-xs-12">
            <?= $form->field($commentModel, 'choice_text')->widget(Select2::classname(), [
                'data' => $thread_choices,
                'hideSearch' => true,
                'options' => ['placeholder' => 'Choose your side ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false) ?>
        </div>

        <div align="right" class="col-xs-12">
            <?= Html::hiddenInput('thread_id', $thread_id) ?>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'style' => 'width: 100%;'])?>
        </div>


    </div>

</div>

<?php ActiveForm::end(); ?>
