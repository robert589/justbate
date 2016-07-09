<?php
namespace common\libraries;
use Yii;

class ImageUtility{
    const LOADING_GIF = "img/loading.gif";

    public static function getResourceUrl($resource){
        $baseUrl = Yii::$app->request->baseUrl . '/frontend/web/';
        return $baseUrl . $resource;
    }


}