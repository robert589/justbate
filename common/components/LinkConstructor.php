<?php
namespace common\components;


class LinkConstructor{

    public static function threadLinkConstructor($id , $title){
        return \Yii::$app->request->baseUrl . '/thread/' . $id . '/' . str_replace(' ' , '-', strtolower($title));
    }
}

?>