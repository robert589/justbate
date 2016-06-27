<?php

namespace frontend\vo;

class ThreadCommentVoBuilder extends CommentVoBuilder {


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



    function build(){
        return new ThreadCommentVo($this);
    }



}