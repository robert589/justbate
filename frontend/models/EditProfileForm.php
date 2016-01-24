<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

class EditProfileForm extends Model
{
	public $first_name;
	public $last_name;
	public $birthday;
	public $occupation;

	public function rules()
	{
		return[
			[['first_name','last_name','birthday', 'occupation'], 'required'],
			['birthday', 'date', 'format' => 'mm/dd/yyyy'],
			['birthday', 'safe']
		];
	}

	public function edit()
    {
        if ($this->validate()) {
        	$id = \Yii::$app->user->identity->id;
        	$user = User::findOne(['id' => $id]);
			$user->first_name = $this->first_name;
			$user->last_name = $this->last_name;
			//Yii::$app->end($this->birthday);
			$user->birthday = date('Y-m-d', strtotime($this->birthday));
			$user->occupation = $this->occupation;
			if($user->update()){
				return $user;
            }
        }

        return null;
    }


	
}
