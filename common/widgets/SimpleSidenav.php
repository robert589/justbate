<?php
namespace common\widgets;
use yii\base\Widget;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SimpleSidenav extends Widget
{
    public $items;      
    
    public $class;
    
    public $id;
        
    public $item_class;
    
    public $title;
    
    public $header_btn_label;
    
    public $header_btn_id;
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }
    
    public function registerAssets() {
        $view = $this->getView();
        SimpleSidenavAsset::register($view);
            
    }

    public function run()
    {
        if($this->item_class === null) {
            $this->item_class = 'simple-sidenav-item-class';
        }
        
        if(count($this->items) === 0 ) {
            return;
        }
        return $this->render('simple-sidenav', 
                ['items' => $this->items, 
                 'id' => $this->id,
                 'class' => $this->class, 
                 'item_class' => $this->item_class,
                 'title' => $this->title,
                 'header_btn_id' => $this->header_btn_id,
                 'header_btn_label' => $this->header_btn_label
                ]);
    }
}
