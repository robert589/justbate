<?php

namespace common\models;
use yii\db\ActiveRecord;
use Yii;

class Tag extends ActiveRecord{

	public static function tableName()
    {
        return 'tag';
    }


    public static function getTagList($q){
        $sql = "SELECT tag_id as id, tag_name as text
                   from tag
                   where tag_name like concat('%', :q,'%')
                   limit 10";

        return Yii::$app->db->createCommand($sql)->
        bindParam(":q", $q)->
        queryAll();
    }

    /**
     * WRONGGGG, MOTHERFUCKER WRONG, CHANGE PLEASE
     */
    public static function getPopularCategory(){
        $sql = "SELECT tag_name
                from tag
                ";

        return Yii::$app->db->createCommand($sql)->
        queryAll();

    }

    public static function checkExist($tag){
        return Self::find()->where(['tag_id' => $tag])->exists();
    }
}