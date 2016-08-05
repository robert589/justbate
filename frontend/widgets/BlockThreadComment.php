<?php

namespace frontend\widgets;

use frontend\widgets\CommentInputAnonymousAsset;
use yii\base\Widget;

class BlockThreadComment extends Widget
{
    public $thread_comment;
    
    public $id;

    public function init()
    {
        parent::init();

        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        BlockThreadCommentAsset::register($view);

    }

    public function run()
    {
        $cut_comment = \common\libraries\Utility::cutText($this->thread_comment->getComment(), 40);
        return $this->render('block-thread-comment',
            ['thread_comment' => $this->thread_comment, 'id' => $this->id, 'cut_comment' => $cut_comment]);
    }
}