<?php

namespace frontend\vo;

use common\components\DateTimeFormatter;
use Yii;
use yii\data\ArrayDataProvider;

abstract class CommentVo implements Vo{


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
     * @return int
     */
    public function getCommentCreatorId()
    {
        return $this->comment_creator_id;
    }

    /**
     * @return string
     */
    public function getCommentCreatorFirstName()
    {
        return $this->comment_creator_first_name;
    }

    /**
     * @return string
     */
    public function getCommentCreatorLastName()
    {
        return $this->comment_creator_last_name;
    }

    /**
     * @return string
     */
    public function getCommentCreatorPhotoPath()
    {
        return $this->comment_creator_photo_path;
    }

    /**
     * @return int
     */
    public function getCurrentUserVote()
    {
        return $this->current_user_vote;
    }

    /**
     * @return int
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return mixed
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @return int
     */
    public function getCurrentUserLoginId()
    {
        return $this->current_user_login_id;
    }

    /**
     * @return mixed
     */
    public function getTotalLike()
    {
        return $this->total_like;
    }

    /**
     * @return mixed
     */
    public function getTotalDislike()
    {
        return $this->total_dislike;
    }

    /**
     * @return int
     */
    public function getCommentStatus()
    {
        return $this->comment_status;
    }

    /**
     * @return mixed
     */
    public function getAnonymous()
    {
        return $this->anonymous;
    }


    function __construct(CommentVoBuilder $builder)
    {
        $this->anonymous = $builder->getAnonymous();
        $this->comment_status = $builder->getCommentStatus();
        $this->total_dislike = $builder->getTotalDislike();
        $this->total_like = $builder->getTotalLike();
        $this->comment = $builder->getComment();
        $this->current_user_vote = $builder->getCurrentUserVote();
        $this->current_user_login_id = $builder->getCurrentUserLoginId();
        $this->choices = $builder->getChoices();
        $this->created_at = $builder->getCreatedAt();
        $this->updated_at = $builder->getUpdatedAt();
        $this->comment_creator_first_name = $builder->getCommentCreatorFirstName();
        $this->comment_creator_last_name = $builder->getCommentCreatorLastName();
        $this->comment_creator_username = $builder->getCommentCreatorUsername();
        $this->comment_creator_id = $builder->getCommentCreatorId();

    }

}