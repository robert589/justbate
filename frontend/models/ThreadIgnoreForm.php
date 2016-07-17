<?php

use common\models\ThreadIgnore;
/**
 * Signup form
 */
class ThreadIgnoreForm extends Model
{
    public $user_id;
    public $thread_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'thread_id'] , 'required'],
            [['user_id', 'thread_id'] , 'integer']
       ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function store()
    {
        if ($this->validate()) {
            if(!$this->exist()){
               return $this->addThreadIgnore();
            }
        }
        return null;
    }

    private function exist(){
        return ThreadIgnore::find()->where(['user_id' => $this->user_id, 
                                'thread_id' => $this->thread_id])->exists();
    }

    private function addThreadIgnore(){
        $thread_ignore = new ThreadIgnore();
        $thread_ignore->user_id = $this->user_id;
        $thread_ignore->thread_id = $this->thread_id;
        if($thread_ignore->save()) {
            return true;
        }
        return false;

    }

}


