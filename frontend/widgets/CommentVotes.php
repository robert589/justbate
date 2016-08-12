<?php
namespace frontend\widgets;

use yii\base\Widget;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;

class CommentVotes extends Widget
{

    /**
     * @var ArrayDataProvider
     */
    
    public $id;
    
    public $comment;
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        CommentVotesAsset::register($view);

    }

    public function run()
    {
        return $this->render('comment-votes', 
                ['id' => $this->id, 
                'comment' => $this->comment]);
    }
}