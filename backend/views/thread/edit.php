<?php

    use yii\widgets\ActiveForm;
    use kartik\select2\Select2;
    use yii\helpers\Html;
    /** @var $thread array */
    /** @var $edit_thread_form \frontend\models\EditThreadForm */
    /** @var $choices array */
    /** @var $edit_choice_forms array */

?>

<div class="col-md-6 col-md-offset-3">
    <label>Please only correct the grammar, do not change the context</label>
    <hr>

    <?php $form = \yii\widgets\ActiveForm::begin(['action' => 'edit?id=' . $thread['thread_id'], 'method' => 'post', 'id' => 'edit_thread_form']) ?>


    <?= $form->field($edit_thread_form, 'title')->textInput(['value' => $thread['title']]) ?>


    <?= $form->field($edit_thread_form, 'description')->textarea(['value' => $thread['description']]) ?>


    <label>Choices</label>
    <?php foreach($edit_choice_forms as $i => $edit_choice_form){ ?>

        <?= $form->field($edit_choice_form, "[$i]new_choice_text")->textInput(['value' => $edit_choice_form->old_choice_text])->label(false) ?>

    <?php } ?>

    <div align="right">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php \yii\widgets\ActiveForm::end() ?>
</div>

