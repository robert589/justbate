<?php

namespace frontend\models;

use yii\base\Model;
use common\models\UserFollowedIssue;

class EditUserIssueForm extends Model {
    public $issue_list;
    public $user_id;

    public function rules() {
        return [
            ['user_id', 'required' ],
            ['user_id', 'integer'],
            ['issue_list','each', 'rule' => ['string']],
            ['issue_list', 'checkIssue']
        ];
    }

    public function checkIssue() {
        if (count($this->issue_list) < 5) {
            $this->addError('issue_list', 'Issue List is less than 5 items currently:' .$this->issue_list    );
        }
    }
    
    public function  update() {
        $this->deleteAllIssues();
        foreach($this->issue_list as $item) {
            $model = new UserFollowedIssue();
            $model->user_id = $this->user_id;
            $model->issue_name = trim($item);
            if(!$model->save()) {
                return false;
            }

        }
        return true;    

    }
    
    public function deleteAllIssues() {
        return UserFollowedIssue::deleteAll(['user_id' => $this->user_id]);
    }
}

?>
