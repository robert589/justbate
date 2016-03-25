<?php
namespace common\models;

use yii\db\Query;
use yii\db\ActiveRecord;

class FollowerRelation extends ActiveRecord
{
//	public $follower_id;
//	public $followee_id;

	public static function getTable(){
		return 'follower_relation';
	}
	// Returns integer
	public static function getNumFollowers($followee_id) {
		return self::find()
			->where(['followee_id' => $followee_id])
			->count();
	}

	// Returns integer
	public static  function getNumFollowing($follower_id){
		return self::find()
			->where(['follower_id' => $follower_id])
			->count();
	}

	// Identical with getNumFollowing($follower_id)
	public static function getNumFollowings($follower_id) {
		return self::find()
			->where(['follower_id' => $follower_id])
			->count();
	}

	public static function getFollowers($followee_id) {
		$table_name = self::tableName();

		return (new \yii\db\Query())
			->select(['first_name', 'last_name'])
			->from($table_name)
			->join('INNER JOIN', 'user', "user.id = $table_name.follower_id")
			->where("followee_id = $followee_id")
			->all();
	}

	public static function getFollowees($follower_id) {
		return (new \yii\db\Query())
			->select(['first_name', 'last_name'])
			->from(self::tableName())
			->join('INNER JOIN', 'user', "user.id = followee_id")
			->where("follower_id = $follower_id")
			->all();
	}

	public static function isFollowing($follower_id, $followee_id) {
		return self::findOne(['follower_id' => $follower_id, 'followee_id' => $followee_id]) !== null;
	}


}

?>