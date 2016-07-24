<?php
    use yii\helpers\HtmlPurifier;
    use common\components\Constant;
    use yii\helpers\Html;
    /** @var $notification_vo \frontend\vo\NotificationVo */
?>
<div class="col-xs-12 notification list">
    <div class="col-xs-11 notification-list-content">
        <a href="<?= $notification_vo->getUrl() ?>"
           data-arg="<?= $notification_vo->getNotificationId() ?>"
           class="notification-item col-xs-12 inline"
           data-pjax="0">
            <div class="row">
                <div class="inline">
                    <?= Html::img($notification_vo->getPhotoPath(), ['style' => 'height:50px;width:50px'] ) ?>
                </div>
                <span>
                        
                    <?= $notification_vo->getText() ?> <br>
                    <?= $notification_vo->getTime() ?>
                
                </span>
            </div>
        </a>
    </div>
    <?php if(!$notification_vo->getRead()) { ?>
        <div class="col-xs-1 notification-list-status">
            <i class="fa fa-circle notification-read" aria-hidden="true"></i>
        </div>
    <?php } ?>
</div>
