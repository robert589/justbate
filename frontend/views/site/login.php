<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

if(empty($redirect_from)){
    $redirect_from = Yii::getAlias('@base-url') ;
}

?>
<div class="site-login">
    <h1><?= Html::encode('Login') ?></h1>

    <?php $form = ActiveForm::begin(['action' => ['site/login'], 'method' => 'post']) ?>
        <table class="table table-responsive table-bordered" align="center" id="login-form">
            <?= $form->field($login_form, 'username')->textInput(['placeholder' => 'Your Username']) ?>
            <?= $form->field($login_form, 'password')->passwordInput(['placeholder' => 'Your Password']) ?>

        </table>
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
        <div class="row">
            <div id="social-icon">
                <div class="col-xs-4"><a class="btn btn-md btn-block btn-social btn-twitter" id="socmed-login"><span class="fa fa-twitter"></span> Sign in with Twitter</a></div>
                <div class="col-xs-4"><a class="btn btn-md btn-block btn-social btn-facebook" id="socmed-login"><span class="fa fa-facebook"></span> Sign in with Facebook</a></div>
                <div class="col-xs-4"><a class="btn btn-md btn-block btn-social btn-google" id="socmed-login"><span class="fa fa-google"></span> Sign in with Google</a></div>
            </div>
        </div>

        <?= Html::hiddenInput('redirect_from', $redirect_from) ?>
    <?php ActiveForm::end() ?>
</div>
