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
	public $user_id;
	public $category;
	public $anonymous;
	public $description;
	public $user_choice;
	public $choice_one;
	public $choice_two;
	public $choice_three;
	public $choice_four;
	public $choice_five;
	public $choice_six;
	public $choice_seven;
	public $choice_eight;

	public function rules()
	{
		return [
			[['user_id', 'title', 'description','user_choice'], 'required'],
			['anonymous', 'boolean'],
			['user_id' , 'integer'],
			['category', 'string'],
			[
			['choice_one', 'choice_two', 'choice_three', 'choice_four',
			'choice_five', 'choice_six','choice_seven', 'choice_eight'], 'unique',
			'targetAttribute' => ['choice_one', 'choice_two', 'choice_three', 'choice_four', 'choice_five',
				'choice_six', 'choice_seven', 'choice_eight']
			],

			[ ['choice_one', 'choice_two', 'choice_three', 'choice_four',
				'choice_five', 'choice_six','choice_seven', 'choice_eight'], 'string']
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
			$thread->poster_choice = $this->user_choice;
			//save it
			if($thread->save()){
				//For prototyping only, please remove it
				if($this->choices == null){
					$this->choices = ['Agree', 'Disagree', 'Neutral'];
				}


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