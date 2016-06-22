<?php
    use yii\helpers\HtmlPurifier;
    use common\components\Constant;
    use yii\helpers\Html;
    /** @var $notification_vo \frontend\vo\NotificationVo */
?>
<div class="col-xs-12">


    <a href="<?= $notification_vo->getUrl() ?>" class="notification-item col-xs-12 inline"
       style="display: block;height:50px;width:100%;margin-bottom: 5px;margin-top:5px"">
        <div class="inline" style="margin-right: 5px">
            <?= Html::img($notification_vo->getPhotoPath(), ['style' => 'height:50px;width:50px'] ) ?>
        </div>
        <?= $notification_vo->getText() ?>
    </a>
</div>
