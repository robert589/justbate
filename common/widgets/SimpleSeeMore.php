<?php
namespace common\widgets;
use yii\base\Widget;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SimpleSeeMore extends Widget
{
    const CUT_POINT = 140;
    
    public $id;

    public $text;      
    
    public $active;
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }
    
    public function registerAssets() {
        $view = $this->getView();
        SimpleSeeMoreAsset::register($view);
            
    }

    public function run()
    {
        if(strlen($this->text) <= self::CUT_POINT) {
            $cut_text = $this->text;
        } else {
            $cut_text= \common\libraries\Utility::cutText($this->text, self::CUT_POINT);
        }
            
        if(strcmp($cut_text,$this->text) === 0) {
            $this->active = false;
        }
        
        return $this->render('simple-see-more', 
                ['active' => $this->active,
                 'text' => $this->text,
                 'cut_text' => $cut_text,
                 'id' => $this->id]);
    }
}
