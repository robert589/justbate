<?php
use \yii\web\Request;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);



return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '1681620248755767',
                    'clientSecret' => '19c1e888bf719334726be35d58cff0f0',
                ],
            ],
        ],
        'urlManager' => [
                'class' => 'yii\web\UrlManager',
                'enablePrettyUrl' => true,
                'showScriptName' => false,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'modules' => [
        'social' => [
            // the module class
            'class' => 'kartik\social\Module',


            // the global settings for the Facebook plugins widget
            'facebook' => [
                'appId' => '1681620248755767',
                'secret' => '19c1e888bf719334726be35d58cff0f0',
            ],
        ],
        // your other modules
    ],
    'params' => $params,
];
