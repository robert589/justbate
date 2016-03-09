<?php

use yii\widgets\ActiveForm;
use kartik\select2\Select2;

use yii\helpers\Html;

/** @var $comment array */
/** @var $edit_comment_form \frontend\models\EditThreadForm */


?>

<div class="col-md-6 col-md-offset-3">
    <label>Please only correct the grammar, do not change the context</label>
    <hr>

    <?php $form = \yii\widgets\ActiveForm::begin(['action' => 'edit-child?id=' . $comment['comment_id'], 'method' => 'post']) ?>


    <?= $form->field($edit_comment_form, 'comment')->textInput(['value' => $comment['comment']]) ?>




    <div align="right">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php \yii\widgets\ActiveForm::end() ?>
</div>

