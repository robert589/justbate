<?php

namespace common\models;

use yii\db\ActiveRecord;

class ThreadRate extends ActiveRecord
{
	public static function getTable(){
		return 'thread_rate';
	}

	public static function getAverageRate($thread_id){
		$sql  = "SELECT avg(rate)as avg_rating from thread_rate where thread_id = :thread_id";

		return   \Yii::$app->db->createCommand($sql)->
		bindParam(':thread_id', $thread_id)->
		queryOne()['avg_rating'];
	}

	public static function getTotalRaters($thread_id){
		$sql = "SELECT count(*) as total_raters from thread_rate where thread_id = :thread_id";

		return (int) \Yii::$app->db->createCommand($sql)->
		bindParam(':thread_id', $thread_id)->
		queryOne()['total_raters'];
	}



}