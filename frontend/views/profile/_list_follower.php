<?php
    use yii\helpers\Html;
    /** @var $model array */
?>

<div style="font-size:15px;vertical-align: center" >

    <?= \yii\helpers\Html::a( Html::encode($model['first_name'] . ' ' .  $model['last_name']),
        Yii::$app->request->baseUrl . '/user/' .  $model['username']) ?>
    <br>
    <hr>
</div>