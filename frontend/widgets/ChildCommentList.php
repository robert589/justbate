<?php
namespace frontend\widgets;

use yii\base\Widget;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;

class ChildCommentList extends Widget
{

    /**
     * @var ArrayDataProvider
     */
    
    public $id;
    
    public $child_comments;
    
    public $child_comment_form;
    


    public $navigationText = 'Load more..';

    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        ChildCommentListAsset::register($view);

    }

    public function run()
    {
        return $this->render('child-comment-list', 
                ['id' => $this->id, 
                'child_comments' => $this->child_comments,
                'child_comment_form' => $this->child_comment_form]);
    }
}