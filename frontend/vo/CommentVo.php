<?php

namespace frontend\vo;

use common\components\DateTimeFormatter;
use common\libraries\UserUtility;
use Yii;
use yii\data\ArrayDataProvider;

abstract class CommentVo implements Vo{
    protected $comment_id;

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
    public function getUserProfileLink()
    {
        return UserUtility::buildUserLink($this->comment_creator_username);
    }

    /**
     * @return int
     */
    public function getCommentCreatorId()
    {
        return $this->comment_creator_id;
    }


    public function getFullName(){
        if($this->anonymous){
            return 'Anonymous-' . $this->anonymous;
        }
        else{
            return UserUtility::getFullName($this->comment_creator_first_name, $this->comment_creator_last_name);
        }
    }

    /**
     * @return string
     */
    public function getCommentCreatorPhotoLink()
    {
        if($this->anonymous){
            return UserUtility::buildPhotoPath('default.png');
        }
        else{
            return UserUtility::buildPhotoPath($this->comment_creator_photo_path);
        }
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
        return DateTimeFormatter::getTimeByTimestampAndTimezoneOffset($this->created_at);
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return DateTimeFormatter::getTimeByTimestampAndTimezoneOffset($this->updated_at);
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

    /**
     * @return mixed
     */
    public function getCommentId()
    {
        return $this->comment_id;
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
        $this->comment_id = $builder->getCommentId();
        $this->comment_creator_photo_path = $builder->getCommentCreatorPhotoPath();
    }


    /**
     * @return int
     */
    public function isBelongToCurrentUser(){
        if (\Yii::$app->user->isGuest) {
            $belongs = 0;
        }
        else {
            if(\Yii::$app->user->getId()== $this->comment_creator_id){
                $belongs = 1;
            } else {
                $belongs = 0;
            }
        }

        return $belongs;

    }


}