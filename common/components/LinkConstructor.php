<?php
namespace common\components;


class LinkConstructor{

    /**
     * @param $id
     * @param $title
     * @return string
     */
    public static function threadLinkConstructor($id , $title){
        return \Yii::$app->request->baseUrl . '/thread/' . $id . '/' . str_replace(' ' , '-', strtolower($title));
    }

    /**
     * @param $username
     * @return string
     */
    public static function userLinkConstructor($username)
    {
        return \Yii::$app->request->baseUrl . '/user/' . $username;
    }


}
?>