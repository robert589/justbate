<?php

namespace frontend\vo;

class ThreadVoBuilder implements  Builder{

    private $thread_id;

    private $thread_comment_list;

    private $title;

    private $description;

    private $created_at;

    private $updated_at;

    private $thread_status;

    private $thread_creator_user_id;

    private $current_user_vote;

    private $thread_issues;

    private $mapped_choices;

    private $choices;

    private $current_user_anonymous;

    private $total_comments;

    private $chosen_comment;
    
    private $has_current_user_comment;
    
    private $current_user_comment;
    
    public function setCurrentUserComment($current_user_comment) {
        $this->current_user_comment = $current_user_comment;
    }
    
    public function getCurrentUserComment() {
        return $this->current_user_comment;
    }
    
    public function hasCurrentUserComment() {
        return $this->has_current_user_comment;
    }

    public function setHasCurrentUserComment($has_current_user_comment) {
        $this->has_current_user_comment = $has_current_user_comment;
    }

        /**
     * @return mixed
     */
    public function getCurrentUserAnonymous()
    {
        return $this->current_user_anonymous;
    }

    /**
     * @param mixed $current_user_anonymous
     */
    public function setCurrentUserAnonymous($current_user_anonymous)
    {
        $this->current_user_anonymous = $current_user_anonymous;
    }



    public function build(){
        return new ThreadVo($this);
    }

    /**
     * @return mixed
     */
    public function getThreadCommentList()
    {
        return $this->thread_comment_list;
    }

    /**
     * @param mixed $thread_comment_list
     */
    public function setThreadCommentList($thread_comment_list)
    {
        $this->thread_comment_list = $thread_comment_list;
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
    public function getThreadIssues()
    {
        return $this->thread_issues;
    }

    /**
     * @param mixed $thread_issues
     */
    public function setThreadIssues($thread_issues)
    {
        if(!is_array($thread_issues )) {
            $this->thread_issues  = explode("%,%", $thread_issues);

        }
        else{
            foreach($thread_issues as $thread_issue) {
                $this->thread_issues[] = $thread_issue['issue_name'];
            }
        }
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
        $this->choices = explode("%,%", $choices);
    }

    /**
     * @return mixed
     */
    public function getTotalComments()
    {
        return $this->total_comments;
    }

    /**
     * @param mixed $total_comments
     */
    public function setTotalComments($total_comments)
    {
        $this->total_comments = $total_comments;
    }



    /**
     * @return mixed
     */
    public function getMappedChoices()
    {
        return $this->mapped_choices;
    }

    /**
     * @param mixed $mapped_choices
     */
    public function setMappedChoices($mapped_choices)
    {
        $this->mapped_choices = $mapped_choices;
    }

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






}