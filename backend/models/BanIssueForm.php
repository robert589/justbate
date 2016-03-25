<?php

namespace backend\models;

use yii\base\Model;
use common\models\Issue;
use common\models\Thread;
use Yii;

class BanIssueForm extends ModeL {

    public $issue_id;

    public function rules() {
        return [
            [['issue_id'], 'integer'],
            ['issue_id', 'required']
        ];
    }

    public function ban() {
        if($this->validate()) {
            $issue  = Issue::findOne(['issue_id' => $this->issue_id]);
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