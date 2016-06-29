<?php

namespace backend\models;

use yii\base\Model;
use common\models\Issue;
use common\models\Thread;
use Yii;

class BanIssueForm extends Model {

    public $issue_name;

    public function rules() {
        return [
            [['issue_name'], 'string'],
            ['issue_name', 'required']
        ];
    }

    public function ban() {
        if($this->validate()) {
            $issue  = Issue::findOne(['issue_name' => $this->issue_name]);
            $issue->issue_status = Issue::STATUS_BANNED;
            if($issue->update()){
                return true;
            }
            else{
                return false;
            }
        }
        return true;
    }
}

?>
