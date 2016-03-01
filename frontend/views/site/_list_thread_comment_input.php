<?php
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Html;
?>


<!--Comment Input Part-->
<?php $form =ActiveForm::begin(['action' => ['site/submit-comment'], 'id' => 'comment-form-' . $thread_id, 'options' => ['data-pjax' => '#comment_section_' . $thread_id]]) ?>

<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($comment_model, 'comment')->textarea(['rows' => 1, 'placeholder' => 'Comment here..'])->label(false) ?>
        </div>

    </div>
    <div class="row">
        <div class="col-xs-6">
            <?= $form->field($comment_model, 'choice_text')->widget(Select2::classname(), [
                'data' => $thread_choices,
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
