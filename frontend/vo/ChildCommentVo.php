<?php

namespace frontend\vo;

use frontend\vo\ChildCommentVoBuilder;
use frontend\vo\CommentVo;
use frontend\vo\ThreadCommentVoBuilder;
use yii\data\ArrayDataProvider;

class ChildCommentVo extends CommentVo{


    private $parent_id;

    static function createBuilder(){
        return new ChildCommentVoBuilder();
    }

    function __construct(ChildCommentVoBuilder $builder){
        parent::__construct($builder);
        $this->parent_id = $builder->getParentId();

    }

    /**
     * @return mixed
     */
    public function getParentId()
    {
        return $this->parent_id;
    }





}