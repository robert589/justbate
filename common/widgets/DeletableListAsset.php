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
class DeletableListAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web' ;

    public $css = [
        'frontend/web/css/deletable-list.css',
    ];
    public $js = [
        'frontend/web/js/deletable-list.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
