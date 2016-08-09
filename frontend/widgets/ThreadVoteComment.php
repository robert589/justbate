<?php
namespace frontend\widgets;
use yii\base\Widget;
use yii\helpers\HtmlPurifier;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ThreadVoteComment extends Widget
{
    public $thread;
    
    public $id;
    
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }
    
    public function registerAssets() {
        $view = $this->getView();
        ThreadVoteCommentAsset::register($view);
    }

    public function run()
    {
        $thread_choices = $this->thread->getMappedChoices();
        $current_user_choice = $this->thread->getCurrentUserVote();
        $propered_choice_text = array();
        foreach($thread_choices as $item){
            $item_values = array_values($item);
            $propered_choice_text[$item_values[0]]  = HTMLPurifier::process($item_values[0] . " (" . $item['total_voters'] . ")");
        }
        return $this->render('thread-vote-comment', 
                ['items' => $propered_choice_text, 
                 'id' => $this->id,
                'thread' => $this->thread,
                'selected' => $current_user_choice, 
                'thread_id' => $this->thread->getThreadId()]);
    }
}
