<?php
namespace frontend\widgets;

use yii\base\Widget;

class ChildComment extends Widget
{
    /** @var  $array  array  */
    public $child_comment;

    public $id;
    
    public $class = '';

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
            ['child_comment' => $this->child_comment, 
                'id' => $this->id, 'class' => $this->class]);
    }
}