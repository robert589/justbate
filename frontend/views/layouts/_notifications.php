<?php
    use yii\widgets\ListView;
?>

<?= ListView::widget([
    'dataProvider' => $recent_tags_provider,
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
