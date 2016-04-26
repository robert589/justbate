<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */
/* @var $is_sign_up_with_fb boolean */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dektrium\user\widgets\Connect;

$this->title = 'Signup';
?>

<div class="col-xs-12 col-md-4" id="signup-page">
    <div class="col-xs-12" >
        <h3 id="signup-title">Registration Form</h3>
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <div class="col-xs-6"><?= $form->field($model, 'first_name')->textInput(['placeholder' => 'First Name', 'class' => 'form-control']) ?></div>
            <div class="col-xs-6"><?= $form->field($model, 'last_name')->textInput(['placeholder' => 'Last Name', 'class' => 'form-control']) ?></div>
            <?= $form->field($model, 'email')->textInput(['class' => 'form-control', 'placeholder' => 'Email Address']) ?>
            <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control', 'placeholder' => 'Your Password']) ?>
            <div class="form-group"><?= Html::submitButton('Register', ['id' => 'signup-button' ,'class' => 'btn btn-primary form-control', 'name' => 'signup-button']) ?></div>
            <?php ActiveForm::end(); ?>
            <?php if($is_sign_up_with_fb != true){ ?>
                <hr id="facebook-separator" /><div align="center" class="col-xs-12" id="facebook-signup"><?= yii\authclient\widgets\AuthChoice::widget(['baseAuthUrl' => ['site/auth']]) ?></div>
                <?php } ?>
            </div>
        </div>
