<?php

namespace frontend\models;

use common\models\Choice;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\web\User;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use common\models\Thread;

class CreateThreadForm extends Model
{
	public $title;
	public $description;
	public $category;
	public $user_id;

	public $anonymous;
	public $choices;

	public function rules()
	{
		return [
			[['user_id', 'title', 'description'], 'required'],
			['anonymous', 'boolean'],
			['user_id' , 'integer'],
			['category', 'string'],
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
			$thread->topic_name = $this->category;

			//save it
			if($thread->save()){

				if($this->saveChoice($this->choices, $thread->thread_id)){

					return $thread->thread_id;

				}
			}
			//save relevant_parties
			return null;
		}
		return true;
	}

	private function saveChoice($choices, $thread_id){
		foreach($choices as $choice_item){
			$choice = new Choice();
			$choice->thread_id = $thread_id;
			$choice->choice_text = $choice_item;
			if(!$choice->save()){
				return null;
			}
		}

		return true;
	}


}