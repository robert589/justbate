<?php

namespace backend\service;

use backend\dao\SiteDao;
use backend\vo\SiteVoBuilder;

class SiteService{

    private $site_dao;

    function __construct(SiteDao $site_dao){
        $this->site_dao = $site_dao;
    }

    public function getSiteInfo(){
        $builder = $this->site_dao->getThreadList(new SiteVoBuilder());
        return $builder->build();
    }
}

 ?>
