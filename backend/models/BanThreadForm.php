<?php

namespace backend\models;

use yii\base\Model;

use common\models\Thread;

class BanThreadForm extends ModeL {

    public $thread_id;

    public function rules() {
        return [
            [['thread_id'], 'integer'],
            ['thread_id', 'required']
        ];
    }

    public function update() {
        if($this->validate()) {
            $thread  = Thread::findOne(['thread_id' => $this->thread_id]);
            $thread->thread_status = Thread::STATUS_BANNED;
            if($thread->update()){
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