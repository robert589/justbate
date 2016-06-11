<?php
namespace frontend\models;

use common\models\User;
use common\models\EmailValidationToken;
use common\models\UserEmailAuthentication;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
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

            ['email', 'filter', 'filter' => 'trim'],
            [['email', 'password'], 'required', 'when' => function($model){
                return $model->facebook_id == '';
            }],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\UserEmailAuthentication', 'message' => 'This email address has already been taken.'],

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
            //Facebook authentication

            $user = new User();
            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;


            if($this->photo_path != null){
                $user->photo_path = $this->photo_path;
            }

            if($this->facebook_id != null){
                $user->facebook_id = $this->facebook_id;
            }

            $user->username = $this->generateUsername();
            
            //$user->setPassword($this->password);

            $user->generateAuthKey();

            if($user->save(false)) {

                if($this->email != null){
                    $user_email_auth = new UserEmailAuthentication();
                    $user_email_auth->user_id = $user->id;
                    $user_email_auth->email = $this->email;
                    if($this->password != null){
                        $user_email_auth->setPassword($this->password);
                    }

                    if($user_email_auth->save()){
                        if (!EmailValidationToken::find()->where(['user_id' => $user->id])->exists()) {
                            $validation_token = new EmailValidationToken();
                            $validation_token->user_id = $user->id;
                            $validation_token->email = $user_email_auth->email;
                            $validation_token->code = EmailValidationToken::generateValidationToken();
                            if ($validation_token->save()) {
                                if($this->facebook_id == ''){
                                    \Yii::$app->mailer->compose(['html' => 'validateToken-html', 'text' => 'validateToken-text'],
                                        ['user' => $user, 'validation_token' => $validation_token->code ])
                                        ->setFrom([\Yii::$app->params['supportEmail'] => 'Justbate.com robot'])
                                        ->setTo($this->email)
                                        ->setSubject('Validate your email in ' . \Yii::$app->name)
                                        ->send();
                                }

                                return $user;

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
                else{
                    return $user;
                }



            }
        }

        return null;
    }

    public function generateUsername(){

        $base_username = strtolower($this->first_name) . ' ' . strtolower($this->last_name);
        $base_username = preg_replace('/\s+/', '.', trim($base_username));
        $i = 0;
        while(true){

            if($i != 0){
                $update_username = $base_username . '.' . $i;
            }
            else{
                $update_username = $base_username;
            }

            if(User::find()->where(['username' => $update_username])->exists()){
                $i++;
            }
            else{
                //Yii::$app->end($update_username);
                return $update_username;
            }
        }

    }
}