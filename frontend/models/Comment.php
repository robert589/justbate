<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class Comment extends ActiveRecord
{
	public function getTable(){
		return 'comment';
	}

	public static function retrieveSqlYesComment($thread_id){
		return "SELECT * from comment inner join user on user.id = comment.user_id where thread_id = $thread_id and yes_or_no  = 1";
	}

	public static function retrieveSqlNoComment($thread_id){
		return "SELECT * from comment inner join user on user.id = comment.user_id where thread_id = $thread_id and yes_or_no  = 0";

	}

	public static function countYesComment($thread_id){
		$sql = "
        SELECT COUNT(*) 
          FROM (SELECT * from comment inner join user on user.id = comment.user_id where thread_id = $thread_id and yes_or_no  = 1) TU
      	";

        $command =  \Yii::$app->db->createCommand($sql)->queryScalar();
      
        return (int)($command);

	}

	public static function countNoComment($thread_id){
		$sql = "
        SELECT COUNT(*) 
          FROM (SELECT * from comment inner join user on user.id = comment.user_id where thread_id = $thread_id and yes_or_no  = 0) TU
      	";

        $command =  \Yii::$app->db->createCommand($sql)->queryScalar();
      
        return (int)($command);
	}
}