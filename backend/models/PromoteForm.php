<?php

namespace backend\models;

use common\models\AuthAssignment;
use yii\base\Model;

use common\models\Thread;

class PromoteForm extends Model {

    public $user_id;
    public $roles;
    public function rules() {
        return [
            [['user_id'], 'integer'],
            ['roles', 'each', 'rule' => ['string']],
            [['user_id', 'roles'], 'required'],

        ];
    }

    public function promote() {
        if($this->validate()) {
            if(AuthAssignment::find()->where(['user_id' => $this->user_id])->exists()){
                if(!AuthAssignment::deleteAll(['user_id' => $this->user_id])){
                    return false;
                }
            }
            foreach($this->roles as $role){
                $auth_assignment = new AuthAssignment();
                $auth_assignment->user_id = $this->user_id;
                $auth_assignment->item_name = $role;
                if(!$auth_assignment->save()){
                    return false;
                }
            }


            return true;
        }
        return false;
    }
}

?>
