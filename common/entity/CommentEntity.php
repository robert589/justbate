<?php

namespace common\entity;

use common\components\DateTimeFormatter;
use Yii;

class CommentEntity implements Entity{

    /**
     * required
     * @type integer
     * @var
     */
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
    private $dateCreated;

    /**
     * @type integer
     * @var
     */
    private $dateUpdated;

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
     * Thread constructor.
     * @param $id
     */
    public function __construct($comment_id, $current_user_login_id){
        $this->comment_id = $comment_id;
        $this->current_user_login_id = $current_user_login_id;
    }


    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }


    public function linkConstructor(){

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
     * @return mixed
     */
    public function getCommentCreatorUsername()
    {
        return $this->comment_creator_username;
    }

    /**
     * @param mixed $anonymous
     */
    public function setAnonymous($anonymous)
    {
        $this->anonymous = $anonymous;
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
    public function getDateCreated()
    {
        return DateTimeFormatter::getTimeByTimestampAndTimezoneOffset($this->dateCreated);
    }

    /**
     * @param mixed $dateCreated
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * @return mixed
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * @param mixed $dateUpdated
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;
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
    public function getCurrentUserVote()
    {
        return $this->current_user_vote;
    }

    /**
     * @param mixed $current_user_vote
     */
    public function setCurrentUserVote($current_user_vote)
    {
        $this->current_user_vote = $current_user_vote;
    }

    /**
     * @return mixed
     */
    public function getCommentCreatorFirstName()
    {
        return $this->comment_creator_first_name;
    }

    /**
     * @param mixed $comment_creator_first_name
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
     * @return mixed
     */
    public function getCommentCreatorPhotoPath()
    {
        return $this->comment_creator_photo_path;
    }

    /**
     * @param mixed $comment_creator_photo_path
     */
    public function setCommentCreatorPhotoPath($comment_creator_photo_path)
    {
        $this->comment_creator_photo_path = $comment_creator_photo_path;
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



    public function setDataFromArray(array  $array){
        $this->comment_id = isset($array['comment_id']) ? $array['comment_id'] : null;
        $this->comment_creator_id = isset($array['user_id']) ? $array['user_id'] : null;
        $this->comment_creator_first_name = isset($array['first_name']) ? $array['first_name'] : null;
        $this->comment_creator_last_name = isset($array['last_name']) ? $array['last_name'] : null;
        $this->comment_creator_username = isset($array['username']) ? $array['username'] : null;
        $this->comment_creator_photo_path = isset($array['photo_path']) ? $array['photo_path'] : null;
        $this->comment = isset($array['comment']) ? $array['comment'] : null;
        $this->dateCreated = isset($array['created_at']) ? $array['created_at'] : null;
        $this->dateUpdated = isset($array['updated_at']) ? $array['updated_at'] : null;
        $this->comment_status = isset($array['comment_status']) ? $array['comment_status'] : null;
        $this->anonymous = isset($array['comment_anonymous']) ? $array['comment_anonymous'] : null;

    }

    public function getFullName(){
        if($this->anonymous){
            return 'Anonymous';
        }
        else{
            return $this->comment_creator_first_name . ' ' . $this->comment_creator_last_name;

        }
    }

    public function getCommentatorPhotoLink(){
        if($this->anonymous){
            return \Yii::getAlias('@image_dir') . '/default.png';

        }
        else{
            return \Yii::getAlias('@image_dir') . '/' . $this->comment_creator_photo_path;

        }
    }

    public function getCommentatorUserProfileLink(){
        if($this->anonymous){
            return '#';
        }
        else{
            return Yii::$app->urlManager->createAbsoluteUrl(['user/' . $this->comment_creator_username]);
        }
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

    public function isAnonymous(){
        return $this->anonymous;
    }
}