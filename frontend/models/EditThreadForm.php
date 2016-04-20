<?php

namespace frontend\models;

use yii\base\Model;

use common\models\Thread;

class EditThreadForm extends Model {
	public $thread_id;
	public $title;
	public $description;
	public $choices;

	public function rules() {
		return [
			[['thread_id'], 'integer'],
			[['title', 'description'], 'string'],
			[['thread_id', 'title'], 'required'],
			['choices', 'each', 'rule' => ['string']],

		];
	}

	public function update() {
		if($this->validate()) {

			$thread_ptr = Thread::findOne(['thread_id' => $this->thread_id]);
			$thread_ptr->title = $this->title;
			$thread_ptr->description = $this->description;
			$thread_ptr->update();

			return true;
		}
		return false;
	}
}

?>