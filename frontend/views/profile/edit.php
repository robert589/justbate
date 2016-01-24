<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\DatePicker;

?>
<div class="profile-edit">
    <h1><?= Html::encode('Edit Profile') ?></h1>

    <p>Please fill out the following fields to complete profile:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-edit']); ?>

                <?= $form->field($model, 'first_name') ?>

                <?= $form->field($model, 'last_name') ?>

                <?= $form->field($model, 'birthday')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Enter birth date ...'],
                    'pluginOptions' => [
                        'autoclose'=>true
                    ]
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'edit-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

