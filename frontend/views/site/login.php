<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dektrium\user\widgets\Connect;

$this->title = 'Signup';
?>
<div class="site-signup" style="background-color: white;">
    <div class="row">
        <div class="col-md-5" style="border-right: 1px solid">
            <div class="site-login" align="center">
                <h1><?= Html::encode('Login') ?></h1>

                <?php $form = ActiveForm::begin(['action' => ['site/login'], 'method' => 'post']) ?>
                <div class="row" id="login-form">
                    <div class="col-xs-12"><?= $form->field($login_form, 'email')->textInput(['placeholder' => 'Your Username']) ?></div>
                    <div class="col-xs-12"><?= $form->field($login_form, 'password')->passwordInput(['placeholder' => 'Your Password']) ?></div>
                </div>

                <div class="row">
                    <div class="col-xs-6" align="center">
                        <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary', 'id' => 'sign-up']) ?>
                    </div>
                    <div class="col-xs-6">
                        <?= $form->field($login_form,'rememberMe')->checkbox() ?>
                    </div>
                </div><hr />
                <div class="row"  align="center">
                    <b>Recommended Login: </b>
                    <br>
                    <?= yii\authclient\widgets\AuthChoice::widget([
                        'baseAuthUrl' => ['site/auth']
                    ]) ?>
                </div>

                <?php ActiveForm::end() ?>
            </div>

        </div>

        <div class="col-md-5 col-md-offset-1">

            <h1><?= Html::encode($this->title) ?></h1>

            <p>Please fill out the following fields to signup:</p>

            <?php $form = ActiveForm::begin(['id' => 'form-signup', 'action' => ['site/signup']]); ?>

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

    </div>
</div>
