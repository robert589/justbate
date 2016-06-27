<?php

namespace frontend\vo;

use common\entity\ChildCommentVo;

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



}