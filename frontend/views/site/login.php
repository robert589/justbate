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
    <div class="col-md-10 col-md-offset-1 col-sm-12" id="login-register-form">
        <div class="col-xs-12" id="justbate-image-logo">
            <img src="<?= Yii::$app->request->baseUrl . '/frontend/web/img/logo.png' ?>" style="height:130px"/>
        </div>
        <div class="col-md-6 col-xs-12" id="register-form">
            <a href="https://www.justbate.com/site/auth?authclient=facebook" id="register-dropdown">
                <span class="input-group register-data">
                    <span class="input-group-addon"><span class="fa fa-facebook"></span></span>
                    <input type="text" class="form-control" value="Continue With Facebook" readonly="true" />
                </span>
            </a>

            <a href="#" id="register-dropdown">
                <span class="input-group register-data">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                    <input type="text" class="form-control" value="Register With Email" readonly="true" />
                </span>
            </a>

            <div class="col-xs-12" id="email-register">
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <div class="col-xs-6"><input class="form-control" type="text" name="Signupform[first_name]" placeholder="First Name" /></div>
                <div class="col-xs-6"><input class="form-control" type="text" name="Signupform[last_name]" placeholder="Last Name" /></div>
                <input class="form-control" type="email" name="Signupform[email]" placeholder="Email Address" />
                <input class="form-control" type="password" name="Signupform[password]" placeholder="Your Password" />
                <div class="col-xs-12">
                    <div class="col-xs-9"><button class="btn btn-primary btn-block" id="register-button">Submit</button></div>
                    <div id="cancel-register-button" class="col-xs-3"><a href="#" id="cancel-register"><div class="col-xs-12">Cancel</div></a></div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
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
                <div id="forgot-password" class="col-xs-12">Forgot Password</div>
                <div class="col-xs-12" id="forgot-password-wrapper">
                    <div class="col-xs-9"><input type="email" class="form-control" placeholder="Your Email" /></div>
                    <div class="col-xs-3"><button style="width: calc(100% + 15px);" class="btn btn-primary btn-block">Submit</button></div>
                    <div class="col-xs-12" id="cancel-button">Cancel</div>
                </div>
                <button id="button-login" class="btn btn-block btn-primary">Login</button>                      
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
</div>
</div>
