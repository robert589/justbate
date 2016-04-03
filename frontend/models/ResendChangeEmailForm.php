<?php
namespace frontend\models;

use common\models\Choice;
use common\models\User;
use common\models\ValidationToken;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class ResendChangeEmailForm extends Model
{

    public $command;
    public $user_email;

    /*
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_email', 'command'], 'required'],
            ['command', 'string']
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function change()
    {
        if ($this->validate()) {
            $user = User::findOne(\Yii::$app->user->id);
            if(ValidationToken::find()->where(['user_id' => \Yii::$app->user->id])->exists()){
                $validation_token = ValidationToken::findOne(['user_id' => \Yii::$app->user->id]);
            }
            else{
                $validation_token = new ValidationToken();
                $validation_token->user_id = $user->id;
                $validation_token->code = ValidationToken::generateValidationToken();
                $validation_token->save();
            }


            if($this->command == 'change'){
                $user->email = $this->user_email;

                return                 $user->update(false);

            }
            else if($this->command == 'resend'){

                if(
                \Yii::$app->mailer->compose(['html' => 'validateToken-html', 'text' => 'validateToken-text'],
                    ['user' => $user, 'validation_token' => $validation_token->code ])
                    ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                    ->setTo($this->user_email)
                    ->setSubject('Validate your email in ' . \Yii::$app->name)
                    ->send()
                ){
                    return true;
                }
            }
            return null;
        }

        return null;

    }
}