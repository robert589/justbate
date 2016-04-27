<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $validation_token string */

$validate_link = Yii::$app->urlManager->createAbsoluteUrl(['site/validate-account', 'token' => $validation_token]);
?>

Hello <?= $user->username ?>,

Follow the link below to reset your password:

<?= $validate_link ?>
