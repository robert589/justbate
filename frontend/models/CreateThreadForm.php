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
	public $topic_description;
	public $user_opinion;
	public $relevant_parties;
	public $choice;

	public function rules()
	{
		return [
			[['user_id', 'title', 'topic_description', 'user_opinion'], 'required'],
			['anonymous', 'boolean'],
			[['user_id'] , 'integer'],
			['topic_name', 'string'],
			['relevant_parties','each', 'rule' => ['integer']],
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
			$thread->topic_description = $this->topic_description;
			$thread->user_opinion = $this->user_opinion;
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