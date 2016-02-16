<?php

namespace common\models;
use yii\db\ActiveRecord;
use yii\db\Query;
use Yii;
class ThreadTopic extends ActiveRecord{

	public static function tableName()
    {
        return 'thread_topic';
    }


    public static function getTopicList($q){
        $sql = "SELECT topic_name as id, topic_name as text
                   from thread_topic
                   where topic_name like concat('%', :q,'%')
                   limit 10";

        return Yii::$app->db->createCommand($sql)->
        bindParam(":q", $q)->
        queryAll();
    }

    /**
     * WRONGGGG, MOTHERFUCKER WRONG, CHANGE PLEASE
     */
    public static function getPopularCategory(){
        $sql = "SELECT topic_name
                from thread_topic
                ";

        return Yii::$app->db->createCommand($sql)->
        queryAll();

    }
}