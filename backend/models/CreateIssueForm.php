<?php

namespace backend\models;

use common\models\Choice;
use yii\base\Model;

use common\models\Thread;

class EditChoiceForm extends ModeL {

    public $issue_name;
    public $issue_description;

    public function rules() {
        return [
            [['issue_name', 'issue_description'], 'string'],
            [['issue_name', 'issue_description'], 'required'],
        ];
    }

    public function create() {
        if($this->validate()) {

        }
        return false;
    }
}

?>