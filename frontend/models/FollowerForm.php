<?php
namespace frontend\models;

use yii\common\Follower;
use yii\base\Model;

class FollowerForm extends Model
{
	public $follower_id;
	public $followee_id;

	public function rules()
	{
		return [
			[['follower_id', 'followee_id'], 'required'],
			[['follower_id', 'followee_id'], 'integer']
		];
	}
}

?>