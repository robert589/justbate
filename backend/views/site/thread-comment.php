<?php

use yii\grid\GridView;
use yii\helpers\Html;
use kartik\dialog\Dialog;
/** @var $thread_comment_provider \yii\data\ArrayDataProvider */

$this->title = "Thread Comment List" ;
?>

<?= Dialog::widget() ?>
<?= GridView::widget([
    'dataProvider' => $thread_comment_provider,
    'columns' => [
        'comment_id',
        'choice_text',
        'thread_id',
        'comment',
        'comment_status',
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
                        'title' => Yii::t('app', 'Banned'),
                        'data-service' => $model['comment_id'],
                        'id' => 'banned_comment_button',
                        'class' => ' banned_comment_button service-link'
                    ]);
                },

            ],
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'edit') {
                    $url = Yii::$app->request->baseUrl . '/comment/edit?id='.  $model['comment_id']; // your own url generation logic
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
