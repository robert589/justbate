<?php

namespace backend\models;

use yii\base\Model;

use common\models\Comment;
use common\models\Issue;

class EditIssueForm extends ModeL {

    public $issue_id;
    public $issue_name;
    public $issue_description;

    public function rules() {
        return [
            [['issue_id'], 'integer'],
            [['issue_name', 'issue_description'], 'string'],
            [['issue_name', 'issue_id'], 'required'],

        ];
    }

    public function update() {
        if($this->validate()) {

            $issue = Issue::findOne(['issue_id' => $this->issue_id]);
            $issue->issue_name = $this->issue_name;
            $issue->issue_description = $this->issue_description;

            $issue->update();
            return true;
        }
        return false;
    }
}

?>