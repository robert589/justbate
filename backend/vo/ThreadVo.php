<?php

namespace backend\vo;

class ThreadVo implements Vo{

    private $thread_id;
    private $title;
    private $user_id;
    private $created_at;
    private $anonymous;
    private $thread_status;
    private $description;
    private $type;

    static function createBuilder(){
        return new ThreadVoBuilder();
    }

    //CONSTRUCTOR
    function __construct(ThreadVoBuilder $builder){
        $this->thread_id = $builder->getThreadId();
        $this->title = $builder->getTitle();
        $this->user_id = $builder->getUserId();
        $this->created_at = $builder->getCreatedAt();
        $this->anonymous = $builder->getAnonymous();
        $this->thread_status = $builder->getThreadStatus();
        $this->description = $builder->getDescription();
        $this->type = $builder->getType();
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
}

 ?>
