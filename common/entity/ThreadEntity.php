<?php

namespace common\entity;


/**
 * Class Thread business entity includes Thread, Thread issues, Thread Choices table
 * Chosen comment also included here
 * @package common\entity
 */
class ThreadEntity implements Entity{

    /**
     * required
     * @type integer
     * @var
     */
    private $thread_id;

    /**
     * required when (anonymous === false)
     * @type integer
     * @var
     */
    private $thread_creator_user_id;

    private $thread_creator_first_name;

    /**
     * @var string
     */
    private $thread_creator_last_name;

    /**
     * @var string
     */
    private $thread_creator_photo_path;

    /**
     * required
     * @type string
     * @var
     */
    private $title;

    /**
     * @type ?string
     * @var
     */
    private $description;

    /**
     * @type array
     * @var
     */
    private $choices;

    /**
     * @type \DateTime
     * @var
     */
    private $dateCreated;


    /**
     * @type \DateTime
     * @var
     */
    private $dateUpdated;

    /**
     * @var ?string
     */
    private $current_user_choice;

    /**
     * @var integer
     */
    private $current_user_login_id;

    /**
     * @var array | null
     */
    private $thread_issues;

    /**
     * @var ThreadCommentEntity
     */
    private $chosen_comment;

    /**
     * @var Comment[]
     */
    private $comment_list;

    /**
     *
     */
    private $anonymous;

    /**
     *
     */
    private $thread_status;

    private $total_comment;

    /**
     * Thread constructor.
     * @param $id
     */
    public function __construct($id, $current_user_login_id){
        $this->thread_id = $id;
        $this->current_user_login_id = $current_user_login_id;
    }





    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }


    public function getThreadLink(){
        return \Yii::$app->request->baseUrl .  "/thread/" . $this->thread_id. '/' . str_replace(' ' , '-', strtolower($this->title)) ;
    }

    //GETTER AND SETTER

    /**
     * @return mixed
     */
    public function getThreadId()
    {
        return $this->thread_id;
    }

    /**
     * @param mixed $thread_id
     */
    public function setThreadId($thread_id)
    {
        $this->thread_id = $thread_id;
    }

    /**
     * @return mixed
     */
    public function getThreadCreatorUserId()
    {
        return $this->thread_creator_user_id;
    }

    /**
     * @param mixed $thread_creator_user_id
     */
    public function setThreadCreatorUserId($thread_creator_user_id)
    {
        $this->thread_creator_user_id = $thread_creator_user_id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
    public function getCurrentUserChoice()
    {
        return $this->current_user_choice;
    }

    /**
     * @param mixed $current_user_choice
     */
    public function setCurrentUserChoice($current_user_choice)
    {
        $this->current_user_choice = $current_user_choice;
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
     * @return array|null
     */
    public function getThreadIssues()
    {
        return $this->thread_issues;
    }

    /**
     * @param array|null $thread_issues
     */
    public function setThreadIssues($thread_issues)
    {
        $this->thread_issues = $thread_issues;
    }

    /**
     * @return ThreadCommentEntity
     */
    public function getChosenComment()
    {
        return $this->chosen_comment;
    }

    /**
     * @param mixed $chosen_comment
     */
    public function setChosenComment($chosen_comment)
    {
        $this->chosen_comment = $chosen_comment;
    }

    /**
     * @return Comment[]
     */
    public function getCommentList()
    {
        return $this->comment_list;
    }

    /**
     * @param Comment[] $comment_list
     */
    public function setCommentList($comment_list)
    {
        $this->comment_list = $comment_list;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
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
    public function getThreadStatus()
    {
        return $this->thread_status;
    }

    /**
     * @param mixed $thread_status
     */
    public function setThreadStatus($thread_status)
    {
        $this->thread_status = $thread_status;
    }

    public function belongToCurrentUser(){
        if (\Yii::$app->user->isGuest) {
            $belongs = 0;
        }
        else {
            if(\Yii::$app->user->getId()== $this->current_user_login_id){
                $belongs = 1;
            } else {
                $belongs = 0;
            }
        }

        return $belongs;
    }

    public function isGuest(){
        return ($this->current_user_login_id === null);
    }

    public function setDataFromArray(array $array){
        $this->thread_id = isset($array['thread_id']) ? $array['thread_id'] : null;
        $this->thread_creator_user_id = isset($array['user_id']) ? $array['user_id'] : null;
        $this->title = isset($array['title']) ? $array['title'] : null;
        $this->thread_creator_first_name = isset($array['first_name']) ? $array['first_name'] : null;
        $this->thread_creator_last_name = isset($array['last_name']) ? $array['last_name'] : null;
        $this->thread_creator_photo_path = isset($array['photo_path']) ? $array['photo_path'] : null;
      // $this->thread_creator_username = isset($array['username']) ? $array['username'] : null;
        $this->dateCreated = isset($array['created_at']) ? $array['created_at'] : null;
        $this->dateUpdated = isset($array['updated_at']) ? $array['updated_at'] : null;
        $this->thread_status = isset($array['thread_status']) ? $array['thread_status'] : null;
        $this->anonymous = isset($array['anonymous']) ? $array['anonymous'] : null;
        $this->description = isset($array['description']) ? $array['description'] : null;
        $this->total_comment = isset($array['total_comments']) ? $array['total_comments'] : null;

    }

    public function hasChosenComment(){
        return ($this->chosen_comment !== null );
    }

    /**
     * @return mixed
     */
    public function getThreadCreatorFirstName()
    {
        return $this->thread_creator_first_name;
    }

    /**
     * @param mixed $thread_creator_first_name
     */
    public function setThreadCreatorFirstName($thread_creator_first_name)
    {
        $this->thread_creator_first_name = $thread_creator_first_name;
    }

    /**
     * @return string
     */
    public function getThreadCreatorLastName()
    {
        return $this->thread_creator_last_name;
    }

    /**
     * @param string $thread_creator_last_name
     */
    public function setThreadCreatorLastName($thread_creator_last_name)
    {
        $this->thread_creator_last_name = $thread_creator_last_name;
    }

    /**
     * @return string
     */
    public function getThreadCreatorPhotoPath()
    {
        return $this->thread_creator_photo_path;
    }

    /**
     * @param string $thread_creator_photo_path
     */
    public function setThreadCreatorPhotoPath($thread_creator_photo_path)
    {
        $this->thread_creator_photo_path = $thread_creator_photo_path;
    }

    /**
     * @return mixed
     */
    public function getTotalComment()
    {
        return $this->total_comment;
    }

    /**
     * @param mixed $total_comment
     */
    public function setTotalComment($total_comment)
    {
        $this->total_comment = $total_comment;
    }

    public function getCommentRequestUrl(){
        return  \Yii::$app->request->baseUrl . '/site/get-comment?thread_id=' . $this->thread_id ;

    }
}
