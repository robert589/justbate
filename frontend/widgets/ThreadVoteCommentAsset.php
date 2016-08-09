<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\widgets;

use yii\web\AssetBundle;

class ThreadVoteCommentAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web' ;

    public $js = [
        'frontend/web/js/thread-vote-comment.js'
    ];


    public $css = [
        'frontend/web/css/thread-vote-comment.css'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
