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
            ['issue_list', 'each', 'rule' => ['string']],

        ];
    }

    public function update() {

    }

}

?>