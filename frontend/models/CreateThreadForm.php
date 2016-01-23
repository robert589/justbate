<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\web\User;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class CreateThreadForm extends Model
{
	public $title;
	public $relevant_parties;
	public $topic_id;
	public $content;
	public $coordinate;
	public $anonymous;

	public function rules()
	{
		return [
			[['title', 'topic_id', 'content'], 'required'],

		];
	}

	public function create(){
		if($this->validate()){
            $thread = new Thread();

            //Yii::$app->end('hello'  . $this->relevant_parties);

            $thread->user_id = \Yii::$app->user->identity->getId();
            $thread->title = $this->title;
            $thread->topic_name = $this->topic_id;
            $thread->content = $this->content;
            $thread->coordinate = $this->coordinate;
			$thread->anonymous  = $this->anonymous;
            if($thread->save()){
                return true;
            }

            return null;


		}

		return true;
		

	}


}