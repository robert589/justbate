<?php

namespace frontend\vo;

use frontend\vo\CommentVo;
use frontend\vo\ThreadCommentVoBuilder;
use yii\data\ArrayDataProvider;

class ThreadCommentVo extends CommentVo{

    private $parent_thread_id;

    private $parent_thread_title;
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
        $this->parent_thread_id = $builder->getParentThreadId();
        $this->parent_thread_title = $builder->getParentThreadTitle();
    }



    public function getChildCommentRequestURL(){
        return \Yii::$app->request->baseUrl . '/thread/get-child-comment?thread_id=' . $this->parent_thread_id . '&comment_id=' . $this->comment_id ;
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
        return new ArrayDataProvider([
            'allModels' => $this->child_comment_list,
            'pagination' => [
                'pageSize' => 5
            ]
        ]);
    }

    /**
     * @return mixed
     */
    public function getParentThreadId()
    {
        return $this->parent_thread_id;
    }


    /**
     * @return mixed
     */
    public function getParentThreadTitle()
    {
        return $this->parent_thread_title;
    }

    public function isRetrieved(){
        return ($this->child_comment_list !== null);
    }


}