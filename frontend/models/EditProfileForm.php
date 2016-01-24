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

	public function rules()
	{
		return[
			[['first_name','last_name','birthday'], 'required'],
			['birthday', 'date']
		];
	}

	public function edit()
    {
        if ($this->validate()) {
        	$id = \Yii::$app->user->identity->id;
        	$user = User::findOne("$id");
			$user->first_name = $this->first_name;
			$user->last_name = $this->last_name;
			$user->birthday = $this->birthday;
			if($user->update()){
				return $user;
            }
        }

        return null;
    }


	
}
