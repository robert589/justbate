<?php

namespace backend\service;

use common\models\Thread;
use backend\dao\ThreadDao;
use backend\vo\ThreadVoBuilder;
use backend\vo\ThreadVo;

class ThreadService{
    private $thread_dao;

    /**
     * Constructor
     * @param ThreadDao $thread_dao
     */
    function __construct(ThreadDao $thread_dao){
        $this->thread_dao = $thread_dao;
    }

    public function getThreadInfo($thread_id, $user_id, ThreadVoBuilder $builder){

    }
}
 ?>
