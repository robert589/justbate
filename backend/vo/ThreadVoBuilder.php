<?php

namespace backend\vo;

class ThreadVoBuilder implements Builder{

    private $thread_id;
    private $title;
    private $user_id;
    private $created_at;
    private $anonymous;
    private $thread_status;
    private $description;
    private $type;

    public function build(){
        return new ThreadVo($this);
    }

    //GETTERS
    public function getThreadId(){
        return $this->thread_id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getUserId(){
        return $this->user_id;
    }

    public function getCreatedAt(){
        return $this->created_at;
    }

    public function getAnonymous(){
        return $this->anonymous;
    }

    public function getThreadStatus(){
        return $this->thread_status;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getType(){
        return $this->type;
    }

    //SETTERS
    public function setThreadId($thread_id){
        $this->thread_id = $thread_id;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function setUserId($user_id){
        $this->user_id = $user_id;
    }

    public function setCreatedAt($created_at){
        $this->created_at = $created_at;
    }

    public function setAnonymous($anonymous){
        $this->anonymous = $anonymous;
    }

    public function setThreadStatus($thread_status){
        $this->thread_status = $thread_status;
    }

    public function setDescription($description){
        $this->description = $description;
    }

}

 ?>
