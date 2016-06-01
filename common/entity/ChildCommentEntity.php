<?php

namespace common\entity;


class ChildCommentEntity extends CommentEntity implements  \JsonSerializable{

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


    public function jsonSerialize()
    {
        echo ($this->getCommentatorUserProfileLink());
        return array(
            'parent_id' => $this->parent_id,
            'comment_id' => $this->comment_id,
            'first_name'=> $this->getCommentCreatorFirstName(),
            'last_name' => $this->getCommentCreatorLastName(),
            'current_user_vote' => $this->getCurrentUserVote(),
            'total_like' => $this->getTotalLike(),
            'total_dislike' => $this->getTotalDislike(),
            'photo_path' => $this->getCommentCreatorPhotoPath(),
            'username' => $this->getCommentCreatorUsername(),
            'comment' => $this->getComment()
         );
    }

    public function convertToTemplate(){
        $this->parent_id = "parent_id";
        $this->comment_id = "comment_id";
        $this->setCommentCreatorFirstName("first_name");
        $this->setCommentCreatorLastName("last_name");
        $this->setCurrentUserVote("current_user_vote");
        $this->setTotalLike("total_like");
        $this->setTotalDislike("total_dislike");
        $this->setCommentCreatorPhotoPath("photo_path");
        $this->setCommentCreatorUsername("username");
        $this->setComment("comment");
    }
}