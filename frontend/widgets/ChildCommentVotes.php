<?php
namespace frontend\widgets;

use yii\base\Widget;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;

class ChildCommentVotes extends Widget
{

    /**
     * @var ArrayDataProvider
     */
    
    public $id;
    
    public $child_comment;
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        ChildCommentVotesAsset::register($view);

    }

    public function run()
    {
        return $this->render('child-comment-votes', 
                ['id' => $this->id, 
                'child_comment' => $this->child_comment]);
    }
}