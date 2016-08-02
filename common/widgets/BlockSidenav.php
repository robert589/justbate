<?php
namespace common\widgets;
use yii\base\Widget;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BlockSidenav extends Widget
{
    public $items;      
    
    public $class;
    
    public $id;
        
    public $selected;
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }
    
    public function registerAssets() {
        $view = $this->getView();
        BlockSidenavAsset::register($view);
            
    }

    public function run()
    {
        
        if($this->class === null) {
            $this->class = 'block-sidenav-container';
        }
        
        return $this->render('block-sidenav', 
                ['items' => $this->items, 
                 'id' => $this->id,
                 'class' => $this->class,
                 'selected' => $this->selected
                ]);
    }
}
