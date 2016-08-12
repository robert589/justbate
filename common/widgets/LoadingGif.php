<?php
namespace common\widgets;
use yii\base\Widget;
use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LoadingGif extends Widget
{
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }
    
    public function registerAssets() {
        $view = $this->getView();
            
    }

    public function run()
    {
        
        
        return 
        Html::img(\Yii::$app->request->baseUrl . '/frontend/web/img/loading.gif',
                ['style' => 'max-height:50px; height: 30px' ]);
   
    }
}
