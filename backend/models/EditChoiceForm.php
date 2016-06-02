<?php

namespace backend\models;

use common\models\Choice;
use yii\base\Model;

use common\models\Thread;

class EditChoiceForm extends Model {

    public $thread_id;
    public $old_choice_text;
    public $new_choice_text;

    public function rules() {
        return [
            [['thread_id'], 'integer'],
            [['old_choice_text', 'new_choice_text'], 'string'],
            [['thread_id', 'old_choice_text', 'new_choice_text'], 'required'],

        ];
    }

    public function update() {
        if($this->validate()) {

            if($this->old_choice_text == $this->new_choice_text){
                $choice_ptr = Choice::findOne(['thread_id' => $this->thread_id, 'choice_text' => $this->old_choice_text]);
                $choice_ptr->choice_text = $this->new_choice_text;
                if(!$choice_ptr->update()){
                    //error
                    return false;
                }
            }

            return true;
        }
        return false;
    }
}

?>
