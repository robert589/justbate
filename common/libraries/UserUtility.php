<?php
namespace common\libraries;
use Yii;

class UserUtility{

    public static function getFullName($first_name, $last_name, $language = 'en'){
        return $first_name  . ' ' . $last_name ;
    }

    public static function buildUserLink($username){
        return Yii::$app->request->baseUrl . '/user/' . $username;

    }

    public static function buildPhotoPath($photo_path){
        return Yii::$app->request->baseUrl . '/frontend/web/photos/' . $photo_path;
    }

}