 <?php

 /* @var $this yii\web\View */
 /* @var $form yii\bootstrap\ActiveForm */
 /* @var $model \frontend\models\SignupForm */

 use yii\helpers\Html;
 use yii\bootstrap\ActiveForm;
 use dektrium\user\widgets\Connect;

 $this->title = 'Login';
 ?>
<div class="container-fluid" id="login-register-wrapper">
    <div class="col-md-6 col-sm-12" id="login-register-form">
        <div class="col-xs-12" id="justbate-image-logo">
            <img src="<?= Yii::$app->request->baseUrl . '/frontend/web/img/logo.png' ?>" style="height:130px"/>
        </div>
        <div class="col-md-6 col-xs-12" id="register-form">
            <a href="https://www.justbate.com/site/auth?authclient=facebook">
                <span class="input-group register-data">
                    <span class="input-group-addon"><span class="fa fa-facebook"></span></span>
                    <input type="text" class="form-control" value="Register With Facebook" readonly="true" />
                </span>
            </a>

            <a href="<?= Yii::$app->request->baseUrl . '/signup' ?>"">
                <span class="input-group register-data">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                    <input type="text" class="form-control" value="Register With Email" readonly="true" />
                </span>
            </a>
            <hr class="hide-md" />
        </div>

        <div class="col-md-6 col-xs-12" id="login-form">
            <?php $form = ActiveForm::begin(['action' => ['site/login'], 'method' => 'post']) ?>
            <div class="col-xs-12">
                <span class="input-group login-data">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <?= $form->field($login_form, 'email')->textInput(['placeholder' => 'Your Email'], ['class' => 'form-control']) ?>
                </span>

                <span class="input-group login-data">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <?= $form->field($login_form, 'password')->passwordInput(['placeholder' => 'Your Password'], ['class' => 'form-control']) ?>
                </span>
                <a href="#"><div id="forgot-password" class="col-xs-12">Forgot Password</div></a>
                <button id="button-login" class="btn btn-block btn-primary">Login</button>                      
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
