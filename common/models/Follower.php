<?php
namespace common\models;

use yii\db\ActiveRecord;

class Follower extends ActiveRecord
{
	public static function getTable() {
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

	public static function getFollowers($followee_id) {
		return self::find()
			->innerJoinWith('user')
			->where(['followee_id' => $followee_id])
			->andWhere(['followee_id' => 'id'])
			->all();
	}

	public static function getFollowees($follower_id) {
		return self::find()
			->innerJoinWith('user')
			->where(['follower_id' => $follower_id])
			->andWhere(['followee_id' => 'id'])
			->all();
	}
}

?>