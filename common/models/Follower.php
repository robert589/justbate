<?php
namespace common\models;

use yii\db\ActiveRecord;

class Follower extends ActiveRecord
{
    public static function getTable() {
        return 'follower_relation';
    }

    public static function getFollower($user_id) {

    }

    public static  function getFollowing($user_id){

    }
}

?>