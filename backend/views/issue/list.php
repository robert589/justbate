<?php

use yii\grid\GridView;
use yii\helpers\Html;
use kartik\dialog\Dialog;
/** @var $issue_provider \yii\data\ArrayDataProvider */

$this->title = "Thread list" ;
?>

<?= Dialog::widget() ?>

<?= GridView::widget([
    'dataProvider' => $issue_provider,
    'columns' => [
        'issue_name',
        'issue_status',
        'issue_description',

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
                        'title' => Yii::t('app', 'Banned'),'data-service' => $model['issue_id'],  'class' => ' banned_issue_button service-link'
                    ]);
                },

            ],
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'edit') {
                    $url = Yii::$app->request->baseUrl . '/issue/edit?id='.  $model['issue_id']; // your own url generation logic
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
