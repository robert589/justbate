<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $validation_token string */

$validate_link = Yii::$app->urlManager->createAbsoluteUrl(['site/validate-account', 'token' => $validation_token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to reset your password:</p>

    <p><?= Html::a(Html::encode($validate_link), $validate_link) ?></p>
</div>
