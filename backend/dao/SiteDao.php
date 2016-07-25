<?php

namespace backend\dao;

use Yii;
use yii\data\ArrayDataProvider;

use backend\vo\SiteVoBuilder;
use backend\vo\SiteVo;
use backend\vo\ThreadVoBuilder;
use common\models\Thread;

class SiteDao{

    // private $thread_dao;
    //
    // public function  __construct()
    // {
    //     $this->thread_dao = new ThreadDao();
    // }

    public function getThreadList(SiteVoBuilder $builder){
        $results = Thread::find()->all();
        $thread_list = array();

        foreach($results as $result){
            $thread_builder = new ThreadVoBuilder();

            // map db result
            $thread_builder->setThreadId($result['thread_id']);
            $thread_builder->setUserId($result['user_id']);
            $thread_builder->setTitle($result['title']);
            $thread_builder->setCreatedAt($result['created_at']);
            $thread_builder->setAnonymous($result['anonymous']);
            $thread_builder->setThreadStatus($result['thread_status']);
            $thread_builder->setDescription($result['description']);

            $thread_list[] = $thread_builder->build();
        }

        // map thread list to array data provider
        $data_provider = new ArrayDataProvider([
            'allModels' => $thread_list,
            'pagination' => [
                'pageSize' =>30,
            ],
        ]);

        $builder->setThreadListProvider($data_provider);
        return $builder;
    }
}

 ?>
