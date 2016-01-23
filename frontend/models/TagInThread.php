<?php

namespace frontend\models;
use yii\db\ActiveRecord;


class TagInThread extends ActiveRecord{

    public static function tableName()
    {
        return 'tag_in_thread';
    }

    public static function getRecentTags($username){
        $sql = "SELECT user.*,  thread.*
                FROM tag_in_thread, user, thread
                where user.username = :username and user.id = tag_in_thread.user_id and thread.thread_id = tag_in_thread.thread_id limit 10";

        // DAO
        return \Yii::$app->db
            ->createCommand($sql)
            ->bindValues([':username' => $username])
            ->queryAll();
    }
}