<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class EditProfileForm extends Model
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
}
