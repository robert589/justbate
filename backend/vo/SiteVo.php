<?php

namespace backend\vo;

class SiteVo implements Vo{
    private $thread_list_provider;

    static function createBuilder(){
        return new SiteVoBuilder();
    }

    //CONSTRUCTOR
    function __construct(SiteVoBuilder $builder){
        $this->thread_list_provider = $builder->getThreadListProvider();
    }

    // GETTERS
    public function getThreadListProvider(){
        return $this->thread_list_provider;
    }
}

 ?>
