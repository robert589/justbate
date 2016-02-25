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

     <ul class='navbar-nav navbar-right nav'>
        <!-- id notif-expansion is used in js to check whether the dropdown is opened or closed-->

<?php   if(isset($recent_notifications_provider)){ ?>
         <li id='notif-expansion' class='dropdown dropdown-large open'>
<?php   }
        else{ ?>
         <li id='notif-expansion' class='dropdown dropdown-large '>
<?php   } ?>

            <a class='dropdown-toggle' onclick='getNotification()' data-toggle='dropdown'>
                Notification
                <b class='caret'></b>
            </a>
            <ul  class='dropdown-menu dropdown-menu-large row'>
                <div class='col-md-12'>
                    <label>
                        <div style='width:400px' align='center'>
                            Notifications
                        </div>
                    </label>
                    <hr>

<?php   if(isset($recent_notifications_provider)){ ?>
            <?= $this->render('_notifications', ['recent_notifications_provider' => $recent_notifications_provider]) ?>
<?php   }else{ ?>
            <?= Spinner::widget(['preset' => 'medium', 'align' => 'center', 'color' => 'blue']) ?>
<?php   } ?>

                </div>
            </ul>
         </li>
     </ul>

<?=  Html::endForm() ?>

<?php
    Pjax::end();
?>