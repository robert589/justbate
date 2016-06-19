<?php
namespace common\components;


class Argument{

    /**
     * @param $id
     * @param $title
     * @return string
     */
    public static function replace($id , $title){
        return \Yii::$app->request->baseUrl . '/thread/' . $id . '/' . str_replace(' ' , '-', strtolower($title));
    }



}
?>