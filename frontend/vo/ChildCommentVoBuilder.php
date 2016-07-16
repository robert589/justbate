<?php

namespace frontend\vo;


class ChildCommentVoBuilder extends CommentVoBuilder {

    private $parent_id;

    /**
     * @return mixed
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param mixed $parent_id
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;
    }




    function build(){
        return new ChildCommentVo($this);
    }




    public function convertToTemplate(){
        $this->parent_id = '~parent_id';
        $this->comment_id = '~comment_id';
        $this->setCommentCreatorFirstName("~first_name");
        $this->setCommentCreatorLastName("~last_name");
        $this->setCurrentUserVote("~current_user_vote");
        $this->setTotalLike("~total_like");
        $this->setTotalDislike("~total_dislike");
        $this->setCommentCreatorPhotoPath("default.png");
        $this->setCommentCreatorUsername("~username");
        $this->setComment("~comment");
    }


}