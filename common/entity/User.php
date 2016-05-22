<?php

namespace common\entity;


/**
 * @package common\entity
 */
class User implements Entity{

    /**
     * required
     * @type integer
     * @var
     */
    private $user_id;

    /**
     * required when (anonymous === false)
     * @type integer
     * @var
     */
    private $first_name;

    /**
     * required
     * @type string
     * @var
     */
    private $username;

    /**
     * @type ?string
     * @var
     */
    private $last_name;

    /**
     * @type array
     * @var
     */
    private $notif_last_seen;

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


    public function linkConstructor(){

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
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @param mixed $dateTime
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
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
     * @return mixed
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

    public function setData(array $array){
        if(isset($array[self::THREAD_CREATOR_USER_ID_MAPPER])){
            $this->thread_creator_user_id = $array[self::THREAD_CREATOR_USER_ID_MAPPER];
        }

        if(isset($array[self::TITLE])){
            $this->title = $array[self::TITLE];
        }

        if(isset($array[self::DESCRIPTION])){
            $this->description = $array[self::DESCRIPTION];
        }

        if(isset($array[self::DATE_CREATED])){
            $this->dateCreated = $array[self::DATE_CREATED];
        }

        if(isset($array[self::DATE_UPDATED])){
            $this->dateUpdated = $array[self::DATE_UPDATED];
        }

        if(isset($array[self::USER_CHOICE])){
            $this->current_user_choice = $array[self::USER_CHOICE];
        }

    }
}
