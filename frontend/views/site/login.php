<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

if(empty($redirectFrom)){
    $redirectFrom = Yii::getAlias('@base-url') ;
}

$social = Yii::$app->getModule('social');
// Render the Login button
$url = Yii::$app->request->getAbsoluteUrl(); // or any absolute url you want to redirect
$helper = $social->getFbLoginHelper($url);
$loginUrl = $helper->getLoginUrl();

?>
<div class="site-login">
    <h1><?= Html::encode('Login') ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['action' => '../site/login', 'method' => 'post', 'id' => 'login-form']); ?>

                <?= $form->field($model, 'username') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <?= Html::hiddenInput('redirectFrom', $redirectFrom) ?>

                <div style="color:#999;margin:1em 0">
                    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

            or

            <?= Html::a('Facebook Login', $loginUrl, ['class'=>'btn btn-primary']) ?>


        </div>
    </div>
</div>