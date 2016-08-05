<?php
namespace frontend\widgets;

use frontend\widgets\CommentInputAnonymousAsset;
use yii\base\Widget;
use yii\helpers\Html;

class ChildComment extends Widget
{
    /** @var  $array  array  */
    public $child_comment;

    public $id;

    public function init()
    {
        parent::init();

        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        ChildCommentAsset::register($view);

    }

    public function run()
    {
        return $this->render('child-comment',
            ['child_comment' => $this->child_comment, 'id' => $this->id]);
    }
}