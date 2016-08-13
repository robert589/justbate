<?php

namespace frontend\models;

use yii\base\Model;

use common\models\Comment;
use common\models\Thread;

class DeleteThreadForm extends Model {
    public $thread_id;
    public $user_id;

    public function rules() {
        return [
            [['thread_id', 'user_id'], 'integer'],
            [['thread_id', 'user_id'], 'required']
                ];
    }

    public function delete() {

        if($this->validate()) {

            if($this->isOwner()) {
                $thread = Thread::findOne(['thread_id' => $this->thread_id]);
                $thread->thread_status = 0;
                return $thread->update();
                
            } else {
                return false;
            }
        }
    }
    
    private function isOwner() {
        return Thread::findOne(['thread_id' => $this->thread_id])->user_id === ((int) $this->user_id) ;
    }


}

?>