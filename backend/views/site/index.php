<?php
use kartik\widgets\SideNav;

/* @var $this yii\web\View */

$this->title = "JustBate - Admin";

$items = [
    ['label' => 'Threads',
    'url' => Yii::$app->request->baseUrl . '/site/thread',
    ],
    ['label' => 'Comments',
        'url' => Yii::$app->request->baseUrl . '/site/comment',
    ]

]
?>

<h1><?= $home->getWelcome() ?></h1>
<p><?= $home->getDesc() ?></p>
