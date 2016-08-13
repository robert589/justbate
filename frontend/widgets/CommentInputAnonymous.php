<?php
namespace frontend\widgets;

use frontend\widgets\CommentInputAnonymousAsset;
use yii\base\Widget;
use yii\helpers\Html;

class CommentInputAnonymous extends Widget
{
    /** @var  $array  array  */
    public $id;
    
    public $anonymous;

    public $thread_id;

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
            ['anonymous' => $this->anonymous, 'thread_id' => $this->thread_id, 'id' => $this->id]);
    }
}