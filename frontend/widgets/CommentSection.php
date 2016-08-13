<?php
namespace frontend\widgets;

use frontend\widgets\CommentInputAnonymousAsset;
use yii\base\Widget;
use yii\helpers\Html;

class CommentSection extends Widget
{
    /** @var  $array  array  */
    public $id;
    

    public function init()
    {
        parent::init();

        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        CommentSection::register($view);

    }

    public function run()
    {
        return $this->render('comment-section',
            ['anonymous' => $this->anonymous, 'thread_id' => $this->thread_id, 'id' => $this->id]);
    }
}