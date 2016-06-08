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

    public function init()
    {
        parent::init();

        if($this->class === null){
            $this->class = "";
        }

        if($this->style === null){
            $this->style = "";
        }

    }

    public function run()
    {
        if($this->list == null){
            return  'No data found';
        }
        return $this->render('deletable-list', ['list' => $this->list,
                                                'class' => $this->class,
                                                'style' => $this->style]);
    }
}