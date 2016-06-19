<?php
namespace common\components;

use yii\helpers\HtmlPurifier;

class Constant{
    public static function DefaultPurifierConfig(){
        $cfg = \HTMLPurifier_Config::createDefault();

        //allow iframes from trusted sources
        $cfg->set('HTML.SafeIframe', true);
        $cfg->set('URI.SafeIframeRegexp', '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%'); //allow YouTube and Vimeo

        return $cfg;
    }

    public static  function removeAllHtmlTag($string){
        $cfg = \HTMLPurifier_Config::createDefault();
        $cfg->set('HTML.Allowed', '');
        return HtmlPurifier::process($string, $cfg);
    }

    public static function defaultButtonRedactorConfig(){
        return ['undo', 'redo', 'format', 'bold', 'italic', 'image', 'lists'];
    }

    public static function defaultPluginRedactorConfig(){
        return ['video', 'fullscreen'];
    }


}

?>