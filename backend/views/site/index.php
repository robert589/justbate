<?php
use kartik\widgets\SideNav;

/* @var $this yii\web\View */

$this->title = 'Welcome to admin page!';

$items = [
    ['label' => 'Threads',
    'url' => Yii::$app->request->baseUrl . '/site/thread',
    ],
    ['label' => 'Comments',
        'url' => Yii::$app->request->baseUrl . '/site/comment',
    ]

]
?>
<div class="site-index">
    <div class="col-md-3">


    </div>

    <div class="col-md-9">

    </div>
</div>
