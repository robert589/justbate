<?php
namespace frontend\models;

use yii\base\Model;
use common\models\FollowerRelation;

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

	public function update(){
		if($this->validate()){
			if(FollowerRelation::isFollowing($this->follower_id, $this->followee_id)){
				return $this->unfollow();
			}
			else{
				return $this->follow();
			}
		}
	}

	public function follow() {
		$following = new FollowerRelation();
		$following->follower_id = $this->follower_id;
		$following->followee_id = $this->followee_id;
		if($following->save()){
			return 1;
		}
		else{
			//error
		}
	}

	public function unfollow() {
		$following = FollowerRelation::findOne(['follower_id' => $this->follower_id, 'followee_id' => $this->followee_id]);
		if($following->delete()){
			return -1;
		}
		else{

		}
	}
}

?>