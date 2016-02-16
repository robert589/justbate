<?php
namespace frontend\models;

use yii\base\Model;

class FollowerForm extends Model
{
	public $follower;
	public $followee;

	public function rules()
	{
		return [
			[['follower', 'followee'], 'required']
		];
	}
}

?>