<?php
namespace frontend\vo;

abstract class CommentVoBuilder implements Builder{

    private $comment_id;

    private $comment_creator_username;

    /**
     * @var integer
     */
    private $comment_creator_id;

    /**
     * @var string
     */
    private $comment_creator_first_name;


    /**
     * @var string
     */
    private $comment_creator_last_name;

    /**
     * @var string
     */
    private $comment_creator_photo_path;

    /**
     * @var integer
     */
    private $current_user_vote;

    /**
     * required
     * @var integer
     */
    private $comment;

    /**
     * @type array
     * @var
     */
    private $choices;

    /**
     * @type integer
     * @var
     */
    private $created_at;

    /**
     * @type integer
     * @var
     */
    private $updated_at;

    /**
     * @var integer
     */
    private $current_user_login_id;

    /**
     * @var
     */
    private $total_like;


    private $total_dislike;


    /**
     * @var integer
     */
    private $comment_status;


    private $anonymous;

    /**
     * @return mixed
     */
    public function getCommentCreatorUsername()
    {
        return $this->comment_creator_username;
    }

    /**
     * @param mixed $comment_creator_username
     */
    public function setCommentCreatorUsername($comment_creator_username)
    {
        $this->comment_creator_username = $comment_creator_username;
    }

    /**
     * @return int
     */
    public function getCommentCreatorId()
    {
        return $this->comment_creator_id;
    }

    /**
     * @param int $comment_creator_id
     */
    public function setCommentCreatorId($comment_creator_id)
    {
        $this->comment_creator_id = $comment_creator_id;
    }

    /**
     * @return string
     */
    public function getCommentCreatorFirstName()
    {
        return $this->comment_creator_first_name;
    }

    /**
     * @param string $comment_creator_first_name
     */
    public function setCommentCreatorFirstName($comment_creator_first_name)
    {
        $this->comment_creator_first_name = $comment_creator_first_name;
    }

    /**
     * @return string
     */
    public function getCommentCreatorLastName()
    {
        return $this->comment_creator_last_name;
    }

    /**
     * @param string $comment_creator_last_name
     */
    public function setCommentCreatorLastName($comment_creator_last_name)
    {
        $this->comment_creator_last_name = $comment_creator_last_name;
    }

    /**
     * @return string
     */
    public function getCommentCreatorPhotoPath()
    {
        return $this->comment_creator_photo_path;
    }

    /**
     * @param string $comment_creator_photo_path
     */
    public function setCommentCreatorPhotoPath($comment_creator_photo_path)
    {
        $this->comment_creator_photo_path = $comment_creator_photo_path;
    }

    /**
     * @return int
     */
    public function getCurrentUserVote()
    {
        return $this->current_user_vote;
    }

    /**
     * @param int $current_user_vote
     */
    public function setCurrentUserVote($current_user_vote)
    {
        $this->current_user_vote = $current_user_vote;
    }

    /**
     * @return int
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param int $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * @param mixed $choices
     */
    public function setChoices($choices)
    {
        $this->choices = $choices;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return int
     */
    public function getCurrentUserLoginId()
    {
        return $this->current_user_login_id;
    }

    /**
     * @param int $current_user_login_id
     */
    public function setCurrentUserLoginId($current_user_login_id)
    {
        $this->current_user_login_id = $current_user_login_id;
    }

    /**
     * @return mixed
     */
    public function getTotalLike()
    {
        return $this->total_like;
    }

    /**
     * @param mixed $total_like
     */
    public function setTotalLike($total_like)
    {
        $this->total_like = $total_like;
    }

    /**
     * @return mixed
     */
    public function getTotalDislike()
    {
        return $this->total_dislike;
    }

    /**
     * @param mixed $total_dislike
     */
    public function setTotalDislike($total_dislike)
    {
        $this->total_dislike = $total_dislike;
    }

    /**
     * @return int
     */
    public function getCommentStatus()
    {
        return $this->comment_status;
    }

    /**
     * @param int $comment_status
     */
    public function setCommentStatus($comment_status)
    {
        $this->comment_status = $comment_status;
    }

    /**
     * @return mixed
     */
    public function getAnonymous()
    {
        return $this->anonymous;
    }

    /**
     * @param mixed $anonymous
     */
    public function setAnonymous($anonymous)
    {
        $this->anonymous = $anonymous;
    }

    /**
     * @return mixed
     */
    public function getCommentId()
    {
        return $this->comment_id;
    }

    /**
     * @param mixed $comment_id
     */
    public function setCommentId($comment_id)
    {
        $this->comment_id = $comment_id;
    }



    abstract function build();



}