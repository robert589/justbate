<?php
namespace frontend\widgets;
use yii\base\Widget;
use frontend\models\CommentForm;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ThreadCommentInputBox extends Widget
{
    public $thread;
    
    public $id;
    
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }
    
    public function registerAssets() {
        $view = $this->getView();
        ThreadCommentInputBoxAsset::register($view);
    }

    public function run()
    {
        return \Yii::$app->controller->renderAjax('../../widgets/views/thread-comment-input-box',
                            ['id' => $this->id,
                            'thread' => $this->thread,
                             'comment_model' => new CommentForm()]);
    }
}
