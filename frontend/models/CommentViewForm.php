<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use common\models\CommentView;

/**
 * Signup form
 */
class CommentViewForm extends Model
{
	public $user_id;
	public $comment_id;
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
            return [
                [['user_id', 'comment_id'] , 'required'],
                [['user_id', 'comment_id'] , 'integer']
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
                   return $this->addCommentView();
                }
            }
            return null;
	}

	private function exist(){
            return CommentView::find()->where(['user_id' => $this->user_id, 
                                    'comment_id' => $this->comment_id])->exists();
	}

	private function addCommentView(){
            $comment_view = new CommentView();
            $comment_view->user_id = $this->user_id;
            $comment_view->comment_id = $this->comment_id;
            if($comment_view->save()) {
                return true;
            }
            return false;

	}

}

