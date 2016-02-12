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

<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($commentModel, 'comment')->textArea([ 'placeholder' => 'add comment box...', 'rows' => 4 ])
                ->label(false)?>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($commentModel, 'choice_text')->widget(Select2::classname(), [
                'data' => $thread_choice,
                'hideSearch' => true,
                'options' => ['placeholder' => 'Choose your side ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false) ?>
        </div>

        <div align="right" class="col-md-6">

            <?= Html::hiddenInput('thread_id', $thread_id) ?>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary'])?>
        </div>


    </div>

</div>

<?php ActiveForm::end(); ?>