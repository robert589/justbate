<?php

use yii\grid\GridView;
use yii\helpers\Html;
use kartik\dialog\Dialog;
/** @var $child_comment_provider \yii\data\ArrayDataProvider */

$this->title = "Child Comment List" ;
?>

<?= Dialog::widget() ?>

<?= GridView::widget([
    'dataProvider' => $child_comment_provider,
    'columns' => [
        'comment_id',

        'parent_id',
        'comment',
        ['class' => 'yii\grid\ActionColumn',
            'template' => '{edit}{banned}',
            'buttons' => [
                'edit' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-edit"></span>', $url, [
                        'title' => Yii::t('app', 'Info'),
                    ]);
                },
                'banned' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, [
                        'title' => Yii::t('app', 'Banned'),'data-service' => $model['comment_id'], 'class' => ' banned_child_comment service-link'
                    ]);
                },

            ],
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'edit') {
                    $url = Yii::$app->request->baseUrl . '/comment/edit-child?id='.  $model['comment_id']; // your own url generation logic
                    return $url;
                }
                else if($action == 'banned'){
                    return null;

                }
            }
        ]


        // ...
    ],
]) ?>
