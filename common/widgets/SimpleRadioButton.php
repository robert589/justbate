<?php
namespace common\widgets;
use yii\base\Widget;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SimpleRadioButton extends Widget
{
    
    public $item_class;
    
    public $items;
    
    public $widget_class;
    
    public $selected;
    
    public $id;
    
    public $arg;
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }
    
    public function registerAssets() {
        $view = $this->getView();
        SimpleRadioButtonAsset::register($view);
    }

    public function run()
    {
        return $this->render('simple-radio-button', 
                ['items' => $this->items, 
                 'id' => $this->id,
                'selected' => $this->selected, 
                'item_class' => $this->item_class, 
                'class' => $this->widget_class,
                'arg' => $this->arg]);
    }
}
