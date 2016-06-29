<?php

namespace frontend\vo;

class ThreadCommentVoBuilder extends CommentVoBuilder {

    private $parent_thread_id;

    private $parent_thread_title;

    /**
     * @type array
     * @var
     */
    private $choice_text;

    private $child_comment_list;

    /**
     * @return mixed
     */
    public function getChoiceText()
    {
        return $this->choice_text;
    }

    public function setChoiceText($choice_text)
    {
        $this->choice_text = $choice_text;
    }

    public function getChildCommentList()
    {
        return $this->child_comment_list;
    }

    public function setChildCommentList($child_comment_list)
    {
        $this->child_comment_list = $child_comment_list;
    }

    /**
     * @return mixed
     */
    public function getParentThreadId()
    {
        return $this->parent_thread_id;
    }/**
     * @param mixed $parent_thread_id
     */
    public function setParentThreadId($parent_thread_id)
    {
        $this->parent_thread_id = $parent_thread_id;
    }

    /**
     * @return mixed
     */
    public function getParentThreadTitle()
    {
        return $this->parent_thread_title;
    }

    /**
     * @param mixed $parent_thread_title
     */
    public function setParentThreadTitle($parent_thread_title)
    {
        $this->parent_thread_title = $parent_thread_title;
    }

    function build(){
        return new ThreadCommentVo($this);
    }



}