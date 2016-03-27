<?php
namespace frontend\models;

use common\models\User;
use common\models\ValidationToken;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $first_name;
    public $last_name;
    public $facebook_id;
    public $photo_path;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name' , 'last_name'], 'string' ],
            ['first_name' , 'required' ],

            ['photo_path', 'string'],
            ['facebook_id', 'integer'],

            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;
            $user->username = $this->username;
            $user->email = $this->email;
            $user->photo_path = $this->photo_path;
            $user->facebook_id = $this->facebook_id;

            $user->setPassword($this->password);

            $user->generateAuthKey();

            if ($user->save(false)) {
                if (!ValidationToken::find()->where(['user_id' => $user->id])->exists()) {
                    $validation_token = new ValidationToken();
                    $validation_token->user_id = $user->id;
                    $validation_token->code = ValidationToken::generateValidationToken();
                    if ($validation_token->save()) {

                        if(
                        \Yii::$app->mailer->compose(['html' => 'validateToken-html', 'text' => 'validateToken-text'],
                            ['user' => $user, 'validation_token' => $validation_token->code ])
                            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                            ->setTo($this->email)
                            ->setSubject('Validate your email in ' . \Yii::$app->name)
                            ->send()
                        ){
                            return $user;
                        }
                    }
                    else{
                        //error
                    }
                }
                else{
                    //error
                }


            }
        }

        return null;
    }
}