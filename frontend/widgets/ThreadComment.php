<?php
namespace frontend\widgets;

use frontend\widgets\CommentInputAnonymousAsset;
use yii\base\Widget;
use yii\helpers\Html;

class ThreadComment extends Widget
{

    private $thread_comment_vo;

    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        CommentInputAnonymousAsset::register($view);

    }

    public function run()
    {
        return $this->render('comment-input-anonymous',
            ['thread_comment' => $this->thread_comment_vo]);
    }
}