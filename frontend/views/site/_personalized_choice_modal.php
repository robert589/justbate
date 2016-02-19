<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin(['action' => 'personalized-choice', 'method' => 'post']) ?>
    <div class="col-md-6">
        <?= $form->field($personalized_choice_form, 'choice_one')->textInput() ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($personalized_choice_form, 'choice_two')->textInput() ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($personalized_choice_form, 'choice_three')->textInput() ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($personalized_choice_form, 'choice_four')->textInput() ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($personalized_choice_form, 'choice_five')->textInput() ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($personalized_choice_form, 'choice_six')->textInput() ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($personalized_choice_form, 'choice_seven')->textInput() ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($personalized_choice_form, 'choice_eight')->textInput() ?>
    </div>

    <div class="col-md-12">
        <div align="right">
            <?= Html::submitButton('Save', ['class' => 'btn btn-default']) ?>
        </div>
    </div>

<?php ActiveForm::end() ?>
