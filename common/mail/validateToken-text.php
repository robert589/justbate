<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$validate_link = Yii::$app->request->baseUrl . 'site/validate-account?token=' .$validation_token ;
?>
Hello <?= $user->username ?>,

Follow the link below to reset your password:

<?= $validate_link ?>
