<?php

    use yii\grid\GridView;
    use yii\helpers\Html;
    use kartik\dialog\Dialog;
    /** @var $thread_provider \yii\data\ArrayDataProvider */

    $this->title = "Thread list" ;
?>

<?= Dialog::widget() ?>

<?= GridView::widget([
    'dataProvider' => $thread_provider,
    'columns' => [
        'thread_id',
        'title',
        'user_id',
        'created_at',
        'anonymous',
        'thread_status',
        'description',
        'type',
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
                        'title' => Yii::t('app', 'Banned'),'data-service' => $model['thread_id'], 'id' => 'banned_thread_button', 'class' => ' banned_thread_button service-link'
                    ]);
                },

            ],
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'edit') {
                    $url = Yii::$app->request->baseUrl . '/thread/edit?id='.  $model['thread_id']; // your own url generation logic
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
