<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\widgets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AutoHeightTextAreaAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web' ;

    public $css = [
        'frontend/web/css/auto-height-text-area.css',
    ];
    
    public $js = [
        'frontend/web/js/auto-height-text-area.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
