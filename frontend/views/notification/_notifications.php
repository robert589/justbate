<?php
use yii\widgets\ListView;
use yii\widgets\Pjax;
/** @var $list_notification_vo \frontend\vo\ListNotificationVo */
?>
<?= ListView::widget([
    'dataProvider' => $list_notification_vo->getListNotificationProvider(),
    'options' => [
        'tag' => 'div',
        'class' => 'list-wrapper',
        'id' => 'list-wrapper',
    ],
    'layout' => "\n{items}\n{pager}",

    'itemView' => function ($notification_vo, $key, $index, $widget) {
        return $this->render('_list_notification',['notification_vo' => $notification_vo]);
    },
    'pager' => [
        'firstPageLabel' => 'first',
        'lastPageLabel' => 'last',
        'nextPageLabel' => 'next',
        'prevPageLabel' => 'previous',
        'maxButtonCount' => 3,
    ],
])
?>

