<?php

namespace backend\entity;

use common\components\DateTimeFormatter;

/**
 * Class Thread business entity includes Thread, Thread issues, Thread Choices table
 * Chosen comment also included here
 * @package common\entity
 */
class ThreadEntity implements Entity
{
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
     * @type \DateTime
     * @var
     */
    private $createdAt;


    /**
     * @type \DateTime
     * @var
     */
    private $updatedAt;

    /**
     * @var integer
     */
    private $current_user_login_id;

    /**
     *
     */
    private $anonymous;

    /**
     *
     */
    private $thread_status;

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

    // GETTER & SETTER

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
     * @return int
     */
    public function getCurrentUserLoginId()
    {
        return $this->current_user_login_id;
    }

    public function getCreatedAt()
    {
        return DateTimeFormatter::getTimeByTimestampAndTimezoneOffset($this->createdAt);
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt()
    {
        return DateTimeFormatter::getTimeByTimestampAndTimezoneOffset($this->updatedAt);
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getAnonymous()
    {
        return $this->anonymous;
    }

    public function setAnonymous($anonymous)
    {
        $this->anonymous = $anonymous;
    }

    public function getThreadStatus()
    {
        return $this->thread_status;
    }

    public function setThreadStatus($thread_status)
    {
        $this->thread_status = $thread_status;
    }

    public function getThreadCreatorUserId()
    {
        return $this->thread_creator_user_id;
    }

    public function setThreadCreatorUserId($thread_creator_user_id)
    {
        $this->thread_creator_user_id = $thread_creator_user_id;
    }
}
