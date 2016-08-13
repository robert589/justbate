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
    
    public $comment_id;
    
    public $chosen_child_comment;
    
    public $child_comment_form;
    
    public $total_remaining_comment;

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
                'chosen_child_comment' => $this->chosen_child_comment,
                'comment_id' => $this->comment_id,
                'total_remaining_comment' => $this->total_remaining_comment,
                'child_comment_form' => $this->child_comment_form]);
    }
}