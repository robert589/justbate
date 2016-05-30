<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        // role based access control using DB Manager
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
];
