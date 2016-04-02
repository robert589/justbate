<?php
namespace frontend\models;

use common\models\Choice;
use common\models\User;
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

            if($this->command == 'change'){
                $choice = new Choice();
                $choice->choice_text = $this->choice_text;
                $choice->thread_id = $this->thread_id;
                if($choice->save()){
                    return true;
                }
            }
            else if($this->command == 'resend'){

            }
            return null;
        }

        return null;

    }
}