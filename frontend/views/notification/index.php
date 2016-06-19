<?php
use yii\widgets\Pjax;
use yii\helpers\Html;
use kartik\widgets\Spinner;

Pjax::begin([
    'id' => 'notifbar',
    'enablePushState' => false,
    'clientOptions' => [
        'container' => '#notifbar',
    ]
]);
?>
<?= Html::beginForm(['notification/index'],
'post',
['id' => 'notification-form', 'data-pjax' => '#notifbar', 'class' => 'form-inline'])?>
<!-- id notif-expansion is used in js to check whether the dropdown is opened or closed -->
<?php if (isset($recent_notifications_provider)) { ?>
    <li id='notif-expansion' class='item dropdown open'>
<?php } else { ?>
    <li id='notif-expansion' class='item dropdown' >
<?php } ?>
        <a href="#" class="dropdown-toggle" style="display: block" id="trigger_notification" data-toggle="dropdown">
            Notification <span style="padding-right: 15px;" id="left-icon" class="glyphicon glyphicon-chevron-down"></span>
        </a>
        <ul class="dropdown-menu container-fluid"
            style="background: #fff !important;
            color: black !important;
            height:300px;width:350px;overflow-y: scroll;overflow-x: hidden">

            <div align="center" id="dropdown-menu" style="font-size: 10px"><h4>Notifications (Under development)</h4></div>

            <hr style="margin: 0;">

            <?php if(isset($recent_notifications_provider)) { ?>
                <?= $this->render('_notifications', ['id' => 'dropdown-menu-body',
                                                    'recent_notifications_provider' => $recent_notifications_provider]) ?>
            <?php } else { ?>
                <?= Spinner::widget(['preset' => 'medium', 'align' => 'center', 'color' => 'blue']) ?>
            <?php } ?>

        </ul> <!-- ul.dropdown-menu -->
    </li> <!-- li#notif-expansion -->
<?=  Html::endForm() ?>
<?php Pjax::end(); ?>
