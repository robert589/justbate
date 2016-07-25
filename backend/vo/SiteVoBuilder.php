<?php

namespace backend\vo;

class SiteVoBuilder implements Builder{

    private $thread_list_provider;

    public function build(){
        return new SiteVo($this);
    }

    //GETTERS
    public function getThreadListProvider(){
        return $this->thread_list_provider;
    }

    //SETTERS
    public function setThreadListProvider($thread_list_provider){
        $this->thread_list_provider = $thread_list_provider;
    }
}

 ?>
