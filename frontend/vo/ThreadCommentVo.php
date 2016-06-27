<?php

namespace frontend\vo;

use frontend\vo\CommentVo;
use frontend\vo\ThreadCommentVoBuilder;
use yii\data\ArrayDataProvider;

class ThreadCommentVo extends CommentVo{


    /**
     * ~var integer
     */
    private $choice_text;

    private $child_comment_list;

    static function createBuilder(){
        return new ThreadCommentVoBuilder();
    }

    function __construct(ThreadCommentVoBuilder $builder){
        parent::__construct($builder);
        $this->choice_text = $builder->getChoiceText();
        $this->child_comment_list = $builder->getChildCommentList();

    }

    /**
     * @return mixed
     */
    public function getChoiceText()
    {
        return $this->choice_text;
    }

    /**
     * @return mixed
     */
    public function getChildCommentList()
    {
        return $this->child_comment_list;
    }



}