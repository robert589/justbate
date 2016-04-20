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

<div class="col-md-10 col-md-offset-1" style="background: white">

    <div class="col-md-6" >
        <h1><?= Html::encode($this->title) ?></h1>

        <p>Please fill out the following fields to signup:</p>

        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

        <div class="row">
            <div class="col-lg-6">
                <?= $form->field($model, 'first_name') ?>

            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'last_name') ?>

            </div>

        </div>


        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <?php if($is_sign_up_with_fb != true){ ?>

    <div class="col-md-6" style="border-left: 1px solid">
        <h3 align="center">Sign up with Facebook</h3>
        <hr>
        <div style="margin-left: 65px">
            <?= yii\authclient\widgets\AuthChoice::widget([
                'baseAuthUrl' => ['site/auth']
            ]) ?>
        </div>

    </div>

    <?php } ?>

</div>