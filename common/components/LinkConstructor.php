<?php
namespace common\components;


class LinkConstructor{

    public static function threadLinkConstructor($id , $title){
        return \Yii::$app->request->baseUrl . '/thread/' . $id . '/' . str_replace(' ' , '-', strtolower($title));
    }

    public static function userLinkConstructor($username)
    {
        return \Yii::$app->request->baseUrl . '/user/' . $username;
    }
}
?>