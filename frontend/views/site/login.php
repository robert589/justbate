<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dektrium\user\widgets\Connect;

$this->title = 'Signup';
?>
<div class="container-fluid">
    <div class="col-xs-12">
        <div class="site-signup">
            <div class="row">
                <div class="col-xs-12 col-md-6" style="border-right: 1px solid">
                    <div class="site-login">
                        <h1><?= Html::encode('Login') ?></h1>
                        <?php $form = ActiveForm::begin(['action' => ['site/login'], 'method' => 'post']) ?>

                            <div id="login-form">
                                <div class="col-xs-12"><?= $form->field($login_form, 'email')->textInput(['placeholder' => 'Your Email'], ['class' => 'form-control']) ?></div>
                                <div class="col-xs-12"><?= $form->field($login_form, 'password')->passwordInput(['placeholder' => 'Your Password'], ['class' => 'form-control']) ?></div>
                                <div class="col-xs-6" id="remember-me"><?= $form->field($login_form,'rememberMe')->checkbox() ?></div>
                                <div class="col-xs-6"><?= Html::submitButton('Sign in', ['class' => 'btn btn-primary', 'id' => 'sign-up']) ?></div>
                            </div>

                        <div id="facebook-login">
                            <div align="center"><hr />RECOMMENDED LOGIN<hr /></div>
                            <?= yii\authclient\widgets\AuthChoice::widget(['baseAuthUrl' => ['site/auth']]) ?>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>

                    <div class="col-xs-6">

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
        </div>
    </div>
