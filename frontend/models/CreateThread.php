<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\web\User;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class CreateThread extends Model
{
	public $title;
	public $type;
	public $topic_id;
	public $content;
	public $photo;
	public $date_created;


	public function rules()
	{
		return [
		[['title', 'type', 'topic_id', 'content'], 'required'],
		[['photo'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
		];
	}

	public function create(){
		if($this->validate()){
		$thread = new Thread();
		$file = new Photos();

		$thread->user_id = Yii::$app->user->id; 
		$thread->date_created = $this->timestamp->touch('date_created');
		$thread->title = $this->title;
		$thread->type = $this->type;
		$thread->topic_id = $this->topic_id;
		$thread->content = $this->content;
		$thread->insert();

		if($photo != NULL){
			foreach($this->photo as $image){
				$image->saveAs('uploads/' . $image->baseName . '.' . $image->extension);
				$file->thread_id = $thread->getThreadID();
				$file->image = $image;
				$file->insert();
			}
			
		}

		}
		

	}


}