<?php

namespace frontend\service;


use frontend\dao\CommentDao;
use frontend\dao\ListNotificationDao;
use frontend\dao\SiteDao;
use frontend\dao\ThreadDao;

class ServiceFactory {


    const LIST_NOTIFICATION_SERVICE = "list_notification_service";

    const COMMENT_SERVICE = "comment_service";

    const THREAD_SERVICE = "thread_service";

    const SITE_SERVICE = "site_service";
    public function getService($creatorType ){

        if($creatorType === self::LIST_NOTIFICATION_SERVICE){
            return new ListNotificationService(new ListNotificationDao() );
        }
        else if($creatorType === self::COMMENT_SERVICE) {
            return new CommentService(new CommentDao());

        }
        else if($creatorType === self::THREAD_SERVICE){
            return new ThreadService(new ThreadDao());
        }

        else if($creatorType === self::SITE_SERVICE){
            return new SiteService(new SiteDao());
        }
        return null;
    }
}