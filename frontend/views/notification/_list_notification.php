<?php
    use yii\helpers\HtmlPurifier;
    use common\components\Constant;
    use yii\helpers\Html;
    /** @var $notification_entity \common\entity\NotificationEntity */
?>
<div class="col-xs-12">
<?= Html::img($notification_entity->getPhotoPath() ) ?>

<a href="<?= $notification_entity->getUrl() ?>" class="notification-item col-xs-12 inline"
   style="display: block;height:50px;width:100%">
    <?= $notification_entity->getText() ?>
</a>
</div>
