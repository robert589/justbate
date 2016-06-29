<?php

namespace backend\models;

use yii\base\Model;

use common\models\Comment;
use common\models\Issue;

class EditIssueForm extends Model {

    // public $issue_id;
    public $issue_name;
    public $issue_description;

    public function rules() {
        return [
            //[['issue_id'], 'integer'],
            [['issue_name', 'issue_description'], 'string'],
            [['issue_name'], 'required'],
            // [['issue_name', 'issue_id'], 'required'],

        ];
    }

    public function update($name) {
        if($this->validate()) {
            //can't work earlier
            //reason is because finding the issue by name AFTER changing it
            $issue = Issue::findOne(['issue_name' => $name]);
            $issue->issue_name = $this->issue_name;
            $issue->issue_description = $this->issue_description;

            $issue->update();
            return true;
        }
        return false;
    }
}

?>
