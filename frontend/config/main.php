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
                    'attributeNames' => ['id', 'name', 'email', 'first_name', 'last_name'],
                    'clientSecret' => '19c1e888bf719334726be35d58cff0f0',
                ],
                'twitter' => [
                    'class' => 'yii\authclient\clients\Twitter',
                    'consumerKey' => '6KF1Bq5PNY2xd3Pwpc2DaGUz4 ',
                    'consumerSecret' => 'LpdUmMftiF3eIcONAHzM0WiWEYdQ9jhid42EDTO1j3BeE9xc7r'
                ],
                'google' => [
                    'class' => 'yii\authclient\clients\GoogleOpenId'
                ]
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
        'request'=>[
            'class' => 'common\components\Request',
            'web'=> '/frontend/web'
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
        'redactor' => [
            'class' => 'yii\redactor\RedactorModule',
            'uploadDir' => Yii::getAlias('@image_dir_local'),
            'uploadUrl' => Yii::getAlias('@image_dir'),
            'imageAllowExtensions'=>['jpg','png','gif']
        ],
        // your other modules
    ],
    'params' => $params,
];
