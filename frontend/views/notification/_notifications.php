<?php
use yii\widgets\ListView;
use yii\widgets\Pjax;

?>
<?= ListView::widget([
    'dataProvider' => $recent_notifications_provider,
    'options' => [
        'tag' => 'div',
        'class' => 'list-wrapper',
        'id' => 'list-wrapper',
    ],
    'layout' => "\n{items}\n{pager}",

    'itemView' => function ($model, $key, $index, $widget) {
        return $this->render('_list_notification',['model' => $model]);
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

