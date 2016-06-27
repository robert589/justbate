<?php

namespace frontend\service;


use frontend\dao\CommentDao;
use frontend\dao\ListNotificationDao;

class ServiceFactory {


    const LIST_NOTIFICATION_SERVICE = "list_notification_service";

    const COMMENT_SERVICE = "comment_service";

    public function getService($creatorType ){

        if($creatorType === self::LIST_NOTIFICATION_SERVICE){
            return new ListNotificationService(new ListNotificationDao() );
        }
        else if($creatorType === self::COMMENT_SERVICE) {
            return new CommentService(new CommentDao());

        }
        return null;
    }
}