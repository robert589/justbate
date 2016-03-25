<?php

namespace backend\models;

use common\models\Choice;
use common\models\Issue;
use yii\base\Model;

use common\models\Thread;

class CreateIssueForm extends ModeL {

    public $issue_name;
    public $issue_description;

    public function rules() {
        return [
            [['issue_name', 'issue_description'], 'string'],
            [['issue_name'], 'required'],
        ];
    }

    public function create() {
        if($this->validate()) {
            $issue = new Issue();
            $issue->issue_name = $this->issue_name;
            $issue->issue_description = $this->issue_description;

            if($issue->save()){
                return true;
            }
        }
        return false;
    }
}

?>