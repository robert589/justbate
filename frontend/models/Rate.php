<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class Rate extends ActiveRecord
{
	public function getTable(){
		return 'rate';
	}

	//bad practice, change it
	public function insertRating(){

		if(Self::exists()){
			$model = Self::findOne(['user_id' => $this->user_id, 'thread_id' => $this->thread_id]);
			$model->rating = $this->rating;
			if($model->update()){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			if(Self::save()){
				return true;
			}
			else{
				return false;
			}
		}
	}

	public function exists(){
		return Self::find()
			->where(['user_id' => $this->user_id])
			->andWhere(['thread_id' => $this->thread_id])
			->exists();
	}
}