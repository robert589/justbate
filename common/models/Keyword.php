<?php

namespace common\models;
use yii\db\ActiveRecord;
use yii\db\Query;
use Yii;
class Keyword extends ActiveRecord{

	public static function tableName()
    {
        return 'keyword';
    }


    public static function getTopicList($q){
        $sql = "SELECT name as id, name as text
                   from keyword
                   where name like concat('%', :q,'%')
                   limit 10";

        return Yii::$app->db->createCommand($sql)->
        bindParam(":q", $q)->
        queryAll();
    }

    /**
     * WRONGGGG, MOTHERFUCKER WRONG, CHANGE PLEASE
     */
    public static function getPopularCategory(){
        $sql = "SELECT name
                from keyword
                ";

        return Yii::$app->db->createCommand($sql)->
        queryAll();

    }

    public static function checkExist($keyword){
        return Self::find()->where(['name' => $keyword])->exists();
    }
}