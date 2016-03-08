<?php

namespace backend\models;

use yii\base\Model;

use common\models\Thread;

class EditThreadForm extends ModeL {

    public $thread_id;

    public function rules() {
        return [
            [['thread_id'], 'integer'],
            ['thread_id', 'required']
        ];
    }

    public function update() {
        if($this->validate()) {

            return true;
        }
        return false;
    }
}

?>