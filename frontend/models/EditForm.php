<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

class EditForm extends Model
{
	public $first_name;
	public $last_name;
	public $email;
	public $birthday;

	public function rules()
	{
		return[
			[['first_name','last_name','email','birthday'], 'required'],
			['email','email'],
		];
	}

	public function edit()
    {
        if ($this->validate()) {
            $user = new User();
            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;
            $user->birthday = $this->birthday;
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
	
}

