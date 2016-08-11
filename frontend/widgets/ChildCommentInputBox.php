<?php
namespace frontend\widgets;

use yii\base\Widget;

class ChildCommentInputBox extends Widget
{

    public $id;
    
    public $parent_id;
    
    public $child_comment_form;

    public function init()
    {
        parent::init();

        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        ChildCommentInputBoxAsset::register($view);

    }

    public function run()
    {
        return $this->render('child-comment-input-box',
            ['id' => $this->id, 
            'parent_id' => $this->parent_id,
            'child_comment_form' => $this->child_comment_form]);
    }
}