<?php

namespace common\entity;

class ChildCommentEntity extends CommentEntity{

    /**
     * @var integer
     */
    private $parent_id;

    /**
     * Thread constructor.
     * @param $id
     */
    function __construct($comment_id, $current_user_login_id){
        parent::__construct($comment_id, $current_user_login_id);
    }


    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param int $parent_id
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;
    }


    public function setDataFromArray(array  $array){
        parent::setDataFromArray($array);

        $this->parent_id = isset($array['parent_id']) ? $array['parent_id'] : null;

    }





}