<?php
namespace common\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class InfiniteScroll extends Widget
{

    private $dataProvider;


    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        InfiniteScrollAsset::register($view);

    }

    public function run()
    {
    }
}