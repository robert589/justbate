<?php
use yii\widgets\Pjax;
use yii\helpers\Html;
use kartik\widgets\Spinner;

Pjax::begin([
    'id' => 'notifbar',
    'timeout' => false,
    'enablePushState' => false,
    'clientOptions' => [
        'container' => '#notifbar',
    ]
]);
?>
<?= Html::beginForm(['notification/index'],
'post',
['id' => 'notification-form', 'data-pjax' => '#notifbar', 'class' => 'form-inline'])?>
<!-- id notif-expansion is used in js to check whether the dropdown is opened or closed-->
<?php if (isset($recent_notifications_provider)) { ?>
    <li id='notif-expansion' class='dropdown open item'>
<?php } else { ?>
    <li id='notif-expansion' class='dropdown'>
<?php } ?>
        <a class="dropdown-toggle" onclick="getNotification()" data-toggle="dropdown">notification <b class="caret"></b></a>
        <ul class="dropdown-menu" class="position: absolute;">
            <label style="text-align: center;">notifications</label><hr />
            <?php if(isset($recent_notifications_provider)) { ?>
                <?= $this->render('_notifications', ['recent_notifications_provider' => $recent_notifications_provider]) ?>
            <?php } else { ?>
                <?= Spinner::widget(['preset' => 'medium', 'align' => 'center', 'color' => 'blue']) ?>
            <?php } ?>
        </ul> <!-- ul.dropdown-menu -->
    </li> <!-- li#notif-expansion -->
<?=  Html::endForm() ?>
<?php Pjax::end(); ?>
