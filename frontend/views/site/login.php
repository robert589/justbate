 <?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dektrium\user\widgets\Connect;

$this->title = 'Login';
?>
<div class="site-login" style="background-color: white">
    <div class="row" id="signup-wrapper">
        <div align="center">
            <img src="<?= Yii::$app->request->baseUrl . '/frontend/web/img/logo.png' ?>"
                 style="height:130px">
        </div>
        <h3 align="center" style="color: black;margin-top: 0px">Cause your opinion counts </h3>
    </div>
    <div class="col-md-offset-2 col-md-8" style="border: 1px black solid">
        <div class="col-xs-8 col-md-6">
            <div id="signup-form">
                <div class="col-xs-12" id="signup-table">
                    <div>
                        <?= yii\authclient\widgets\AuthChoice::widget(['baseAuthUrl' => ['site/auth']]) ?>
                    </div>
                    <div>
                        <?= Html::a('<div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-envelope"></i>
                                </span>
                                <input type="text" class="form-control" value="Continue with Email" readonly="true" />
                                </div>',
                            ['site/signup']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-8 col-md-6" id="signin-table">
            <?php $form = ActiveForm::begin(['action' => ['site/login'], 'method' => 'post']) ?>
                <h3>Login</h3>
                <div id="login-form">
                    <div class="col-xs-12">
                        <?= $form->field($login_form, 'email')->textInput(['placeholder' => 'Your Email'], ['class' => 'form-control']) ?>
                    </div>
                    <div class="col-xs-12" style="margin-top:5px">
                        <?= $form->field($login_form, 'password')->passwordInput(['placeholder' => 'Your Password'], ['class' => 'form-control']) ?>
                    </div>
                    <div class="col-xs-6" class="remember-me">
                        <?= Html::a('Forgot password?') ?>
                    </div>
                    <div class="col-xs-6">
                        <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary', 'id' => 'sign-up']) ?>
                    </div>
                </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
