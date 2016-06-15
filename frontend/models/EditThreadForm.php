<?php

namespace frontend\models;

use common\models\Issue;
use common\models\ThreadIssue;
use yii\base\Model;

use common\models\Thread;

class EditThreadForm extends Model {
	public $thread_id;
	public $title;
	public $description;
	public $issues;

	public function rules() {
		return [
			[['thread_id'], 'integer'],
			[['title', 'description'], 'string'],
			[['thread_id', 'title'], 'required'],
			['issues', 'each', 'rule' => ['string']],

		];
	}

	public function update() {
		if($this->validate()) {

			$thread_ptr = Thread::findOne(['thread_id' => $this->thread_id]);
			$thread_ptr->title = $this->title;
			$thread_ptr->description = $this->description;
			$thread_ptr->update();
			if(ThreadIssue::find()->where(['thread_id' => $this->thread_id])->exists()){
				ThreadIssue::deleteAll(['thread_id' => $this->thread_id]);

			}
			$issues = array_values($this->issues);
			foreach($issues as $issue){
				if(!Issue::checkExist($issue)){
					$issue_model = new Issue();
					$issue_model->issue_name = $issue;
					if(!$issue_model->save()){
						return false;
					}
				}

				$thread_issue = new ThreadIssue();
				$thread_issue->thread_id = $this->thread_id;
				$thread_issue->issue_name = $issue;
				if(!$thread_issue->save()){
					return false;
				}
			}

			return true;
		}
		return false;
	}
}

?>