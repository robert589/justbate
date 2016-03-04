<?php

namespace frontend\models;

use common\models\Choice;
use common\models\Tag;
use common\models\ThreadTag;
use Yii;
use yii\base\Model;
use common\models\Thread;

class CreateThreadForm extends Model
{
	public $title;
	public $description;
	public $tags;
	public $user_id;

	public $anonymous;
	public $choices;

	public function rules()
	{
		return [
			[['user_id', 'title', 'tags'], 'required'],
			['description','string'],
			['anonymous', 'boolean'],
			['user_id' , 'integer'],
			['tags', 'each', 'rule' => ['string']],
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
					if($this->saveTags($thread_id)){
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

	private function saveTags($thread_id){
		foreach($this->tags as $tag){
			if(!Tag::checkExist($tag)){
				$tag_model = new Tag();
				$tag_model->tag_name =  $tag;
				if(!$tag_model->save()){
					return false;
				}
			}
			$thread_tag_model = new ThreadTag();
			$thread_tag_model->thread_id = $thread_id;
			$thread_tag_model->tag_id = $tag;
			if(!$thread_tag_model->save()){
				return false;
			}
		}

		return true;
	}


}