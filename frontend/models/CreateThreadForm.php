<?php

namespace frontend\models;

use common\models\Choice;
use common\models\Issue;
use common\models\ThreadIssue;
use Yii;
use yii\base\Model;
use common\models\Thread;

class CreateThreadForm extends Model
{
	public $title;
	public $description;
	public $issues;
	public $user_id;

	public $anonymous;
	public $choices;

	public function rules()
	{
		return [
			[['user_id', 'title', 'issues'], 'required'],
			['description','string'],
			['anonymous', 'boolean'],
			['user_id' , 'integer'],
			['issues', 'each', 'rule' => ['string']],
			['choices', 'each', 'rule' => ['string']],


		];
	}

	public function create(){
		if($this->validate()){
			$thread = new Thread();
			//key in data
			$thread->title = $this->title;
			$thread->user_id = $this->user_id;
			$thread->anonymous = $this->anonymous;
			$thread->description = $this->description;
			//save it
			if($thread->save()){
				$thread_id = $thread->thread_id;
				if($this->saveChoice($thread_id)){
					if($this->saveIssues($thread_id)){
						return $thread_id;
					}
					else{
						//error
						return null;
					}
				}
				else{
					//eror
					return null;
				}
			}
			//save relevant_parties
			return null;
		}
		return false;
	}

	private function saveChoice($thread_id){
		foreach($this->choices as $choice_item){
			$choice = new Choice();
			$choice->thread_id = $thread_id;
			$choice->choice_text = $choice_item;
			if(!$choice->save()){
				return null;
			}
		}

		return true;
	}

	private function saveIssues($thread_id){
		foreach($this->issues as $issue){
			if(!Issue::checkExist($issue)){
				$issue_model = new Issue();
				$issue_model->issue_name = $issue;
				if(!$issue_model->save()){
					return false;
				}
			}
			$thread_issue_model = new ThreadIssue();
			$thread_issue_model->thread_id = $thread_id;
			$thread_issue_model->issue_name = $issue;
			if(!$thread_issue_model->save()){
				return false;
			}
		}

		return true;
	}


}