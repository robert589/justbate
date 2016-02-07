<?php
namespace frontend\models;

use common\models\Choice;
use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class ChoiceForm extends Model
{
    const MAXIMUM_OPTION  = 8;
    const MINIMUM_OPTION = 2;

    public $index;
    public $choice_text;
    public $thread_id;
    public $disabled = true;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['choice_text' ,'string'],
            ['disabled', 'boolean'],
            ['choice_text', 'required', 'when' => function($model){
                return $this->disabled == 0;
            }, 'whenClient' => "function (attribute, value) {
                    return $('#disabled_' + $this->index ).val() == 1;
            }"]
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function store()
    {
        if ($this->validate()) {

            $choice = new Choice();
            $choice->choice_text = $this->choice_text;
            $choice->thread_id = $this->thread_id;
            if($choice->save()){
                return true;
            }
            return null;
        }

        return null;

    }
}