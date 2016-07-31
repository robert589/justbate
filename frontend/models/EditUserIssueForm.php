<?php

namespace frontend\models;

use common\models\Issue;
use common\models\ThreadIssue;
use yii\base\Model;

use common\models\Thread;

class EditUserIssueForm extends Model {
    public $issue_list;
    public $user_id;

    public function rules() {
        return [
            ['user_id', 'integer'],
            ['issue_list', 'check_issue'],
        ];
    }

    public function check_issue() {
        if (count($issue_list) < 5) {
            $this->addError('issue_list', 'Issue List is less than 5 items');
        }
    }
}

?>
