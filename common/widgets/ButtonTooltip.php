<?php
namespace common\widgets;
use yii\base\Widget;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ButtonTooltip extends Widget
{
    public $label;      
    
    public $tooltip;
    
    public $id;
        
    public $class;
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }
    
    public function registerAssets() {
        $view = $this->getView();
        ButtonDropdownAsset::register($view);
            
    }

    public function run()
    {
        
        
        return $this->render('button-dropdown', 
                ['items' => $this->items, 
                 'id' => $this->id,
                 'label' => $this->label
                ]);
    }
}
