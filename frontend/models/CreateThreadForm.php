<?php

namespace frontend\models;

use common\models\Choice;
use common\models\Keyword;
use common\models\ThreadKeyword;
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
	public $keywords;
	public $user_id;

	public $anonymous;
	public $choices;

	public function rules()
	{
		return [
			[['user_id', 'title', 'description'], 'required'],
			['anonymous', 'boolean'],
			['user_id' , 'integer'],
			['keywords', 'each', 'rule' => ['string']],
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
					if($this->saveKeywords($thread_id)){
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
		return true;
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

	private function saveKeywords($thread_id){
		foreach($this->keywords as $keyword){
			if(!Keyword::checkExist($keyword)){
				$keyword_model = new Keyword();
				$keyword_model->name =  $keyword;
				if(!$keyword_model->save()){
					return false;
				}
			}
			$thread_keyword_model = new ThreadKeyword();
			$thread_keyword_model->thread_id = $thread_id;
			$thread_keyword_model->keyword_name = $keyword;
			if(!$thread_keyword_model->save()){
				return false;
			}
		}

		return true;
	}


}