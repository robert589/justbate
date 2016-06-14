<?php

use yii\grid\GridView;
use yii\helpers\Html;
use kartik\dialog\Dialog;
use yii\bootstrap\Modal;
/** @var $user_provider \yii\data\ArrayDataProvider */

$this->title = "Thread list" ;
?>
<?= Dialog::widget() ?>


<?= GridView::widget([
    'dataProvider' => $user_provider,
    'columns' => [
        'id',
        'username',
        ['class' => 'yii\grid\ActionColumn',
            'template' => '{promote}',
            'buttons' => [
                'promote' => function ($url, $model) {
                    return Html::a('Promote', $url);
                }
            ],
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'promote') {
                    $url = Yii::$app->request->baseUrl . '/user/promote?id='.  $model['id']; // your own url generation logic
                    return $url;
                }
            }
        ]


        // ...
    ],
]) ?>
