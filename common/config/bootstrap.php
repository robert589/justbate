<?php
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('frontend-web', dirname(dirname(__DIR__)) . '/frontend/web');
//Yii::setAlias('image_dir', dirname(dirname(__DIR__)) . '/frontend/web/photos');
Yii::setAlias('image_dir', '/startUp/frontend/web/photos');
Yii::setAlias('image_dir_local', dirname(dirname(__DIR__)) . '/frontend/web/photos');
Yii::setAlias('img_dir_local', dirname(dirname(__DIR__)) . '/frontend/web/img');

Yii::setAlias('last_dir_path', dirname(dirname(__DIR__)) . '/frontend/web/photos/last_dir.txt');
//Yii::setAlias('web', dirname(__DIR__))
//;
