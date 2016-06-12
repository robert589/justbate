 <?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dektrium\user\widgets\Connect;

$this->title = 'Login';
?>
<div class="site-login">
    <div class="row">
        <div align="center">
            <img src="<?= Yii::$app->request->baseUrl . '/frontend/web/img/logo.png' ?>"
                 style="height:130px">
        </div>
        <h3 align="center" style="color: black;margin-top: 0px">Cause your opinion counts </h3>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div id="signup-form">
                <div class="col-xs-12" id="signup-title">SIGN UP</div>
                <div class="col-xs-12" id="signup-table">
                    <div class="col-xs-6"><?= yii\authclient\widgets\AuthChoice::widget(['baseAuthUrl' => ['site/auth']]) ?></div>
                    <div class="col-xs-6"><?= Html::a('<div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i></span><input type="text" class="form-control" value="Sign up with Email" readonly="true" /></div>', ['site/signup']) ?></div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6" style="padding-right: 0; padding-left: 0;">
            <?php $form = ActiveForm::begin(['action' => ['site/login'], 'method' => 'post']) ?>
                <div id="login-form">
                    <div id="login-label">SIGN IN</div>
                    <div class="col-xs-12"><?= $form->field($login_form, 'email')->textInput(['placeholder' => 'Your Email'], ['class' => 'form-control']) ?></div>
                    <div class="col-xs-12"><?= $form->field($login_form, 'password')->passwordInput(['placeholder' => 'Your Password'], ['class' => 'form-control']) ?></div>
                    <div class="col-xs-6" id="remember-me"><?= $form->field($login_form,'rememberMe')->checkbox() ?></div>
                    <div class="col-xs-6"><?= Html::submitButton('Sign in', ['class' => 'btn btn-primary', 'id' => 'sign-up']) ?></div>
                </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
