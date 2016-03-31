<?php
    use yii\widgets\ActiveForm;
    use kartik\widgets\Select2;
    use yii\helpers\Html;
    /* @var $thread_choices array **/
    /* @var $commentModel \frontend\models\CommentForm */
    //prepare data
    $choice_text = array();
    foreach($thread_choices as $choice){
        $choice_text[$choice['choice_text']]  = $choice['choice_text'];
    }
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
        <div class="col-xs-6">
            <?= $form->field($commentModel, 'choice_text')->widget(Select2::classname(), [
                'data' => $choice_text,
                'hideSearch' => true,
                'options' => ['placeholder' => 'Choose your side ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false) ?>
        </div>

        <div align="right" class="col-xs-6">
            <?= Html::hiddenInput('thread_id', $thread_id) ?>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'style' => 'width: 100%;'])?>
        </div>


    </div>

</div>

<?php ActiveForm::end(); ?>
