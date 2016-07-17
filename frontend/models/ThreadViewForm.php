<?php

use common\models\ThreadView;
/**
 * Signup form
 */
class ThreadViewForm extends Model
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
               return $this->addThreadView();
            }
        }
        return null;
    }

    private function exist(){
        return ThreadView::find()->where(['user_id' => $this->user_id, 
                                'thread_id' => $this->thread_id])->exists();
    }

    private function addThreadView(){
        $thread_view = new ThreadView();
        $thread_view->user_id = $this->user_id;
        $thread_view->thread_id = $this->thread_id;
        if($thread_view->save()) {
            return true;
        }
        return false;
    }

}


