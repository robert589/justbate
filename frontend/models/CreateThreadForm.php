<?php

namespace frontend\models;

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
	public $topic_name;
	public $anonymous;
	public $description;
	public $choice;
	public $user_choice;

	public function rules()
	{
		return [
			[['user_id', 'title', 'description','user_choice'], 'required'],
			['anonymous', 'boolean'],
			['user_id' , 'integer'],
			['topic_name', 'string'],
			['choice', 'each', 'rule' => ['string']]
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
			$thread->topic_name = $this->topic_name;

			//save it
			if($thread->save()){
				return $thread;
			}

			//save relevant_parties

			return null;


		}

		return true;


	}


}