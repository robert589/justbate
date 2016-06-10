<?php
namespace common\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class DeletableList extends Widget
{
    /** @var  $array  array  */
    public $list;

    public $class;

    public $style;

    public $controller;

    public $id;

    public $post_name_data;

    public function init()
    {
        parent::init();

        if($this->class === null){
            $this->class = "";
        }

        if($this->style === null){
            $this->style = "";
        }

        if($this->controller === null){
            $this->controller = "";
        }

        if($this->id === null){
            $this->id = "home-deletable-list";
        }

        if($this->post_name_data === null){
            $this->post_name_data = "post_name_data";
        }

        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        DeletableListAsset::register($view);

    }

    public function run()
    {
        if($this->list == null){
            return  'No data found';
        }
        return $this->render('deletable-list', ['list' => $this->list,
                                                'class' => $this->class,
                                                'style' => $this->style,
                                                'controller' => $this->controller,
                                                'id' => $this->id,
                                                'name' => $this->post_name_data]);
    }
}