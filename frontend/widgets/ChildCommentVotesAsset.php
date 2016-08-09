<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\widgets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ChildCommentVotesAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web' ;

    public $css = [
        'frontend/web/css/child-comment-votes.css',
    ];
    public $js = [
        'frontend/web/js/child-comment-votes.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
