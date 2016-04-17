<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

if(empty($redirect_from)){
    $redirect_from = Yii::$app->request->baseUrl ;
}

?>
<div class="site-login">
    <h1><?= Html::encode('Login') ?></h1>

    <?php $form = ActiveForm::begin(['action' => ['site/login'], 'method' => 'post']) ?>
    <div class="row" id="login-form">
        <div class="col-xs-12"><?= $form->field($login_form, 'email')->textInput(['placeholder' => 'Your Username']) ?></div>
        <div class="col-xs-12"><?= $form->field($login_form, 'password')->passwordInput(['placeholder' => 'Your Password']) ?></div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary', 'id' => 'sign-up']) ?>
        </div>
        <div class="col-xs-12">
            <div class="input-group" style="width: 100%; border: 0;">
                <span class="input-group-addon"><?= $form->field($login_form,'rememberMe')->checkbox() ?></span>
            </div>
        </div>
    </div><hr />
    <div class="row" align="center">
        <a href="/startUp/site/auth?authclient=facebook" data-popup-width="860" data-popup-height="480">
            <div class="input-group" id="social-icon">
                <span class="input-group-addon"><i class="fa fa-facebook" aria-hidden="true"></i></span>
                <input class="form-control" id='social-icon-text' type='text' readonly='true' value='Login with Facebook' />
            </div>
        </a>
    </div>

    <?= Html::hiddenInput('redirect_from', $redirect_from) ?>
    <?php ActiveForm::end() ?>
</div>
