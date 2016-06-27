<?php
use yii\widgets\Pjax;
use yii\helpers\Html;
use kartik\widgets\Spinner;
/** @var $list_notification_vo \frontend\vo\ListNotificationVoBuilder */
Pjax::begin([
    'id' => 'notifbar',
    'enablePushState' => false,
    'clientOptions' => [
        'container' => '#notifbar',
    ]
]);
?>
    <?= Html::beginForm(['notification/index'], 'post',['id' => 'notification-form', 'data-pjax' => '#notifbar', 'class' => 'form-inline'])?>
    <!-- id notif-expansion is used in js to check whether the dropdown is opened or closed -->
        <?php if (isset($list_notification_vo)) { ?>
        <li id='notif-expansion' class='item dropdown open'>
        <?php } else { ?>
        <li id='notif-expansion' class='item dropdown' >
        <?php } ?>
            <a href="#" class="dropdown-toggle" style="display: block" id="trigger_notification" data-toggle="dropdown">
                Notification <span style="padding-right: 15px;" id="left-icon" class="glyphicon glyphicon-chevron-down"></span>
            </a>
            <ul class="dropdown-menu container-fluid" style="background: #fff !important;
                color: black !important;
                height:300px;width:400px;overflow-y: scroll;overflow-x: hidden">
                <div align="center" id="dropdown-menu" style="font-size: 10px"><h4>Notifications</h4></div>
                <hr style="margin: 0;">
                <?php if(isset($list_notification_vo)) { ?>
                <?= $this->render('_notifications', ['id' => 'dropdown-menu-body',
                                                        'list_notification_vo' => $list_notification_vo]) ?>
                <?php } else { ?>
                <?= Spinner::widget(['preset' => 'medium', 'align' => 'center', 'color' => 'blue']) ?>
                <?php } ?>
            </ul> <!-- ul.dropdown-menu -->
        </li> <!-- li#notif-expansion -->
    <?=  Html::endForm() ?>
<?php Pjax::end(); ?>
