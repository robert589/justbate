<?php

namespace frontend\models;

use yii\base\Model;

use common\models\Comment;
use common\models\Thread;

class DeleteThreadForm extends Model {
    public $thread_id;

    public function rules() {
        return [['thread_id', 'integer'],
            [['thread_id'], 'required']];
    }

    public function delete() {
        if($this->validate()) {
            $thread = Thread::findOne(['thread_id' => $this->thread_id]);
            $thread->thread_status = 0;
            return $thread->update();
        }
    }


}

?>