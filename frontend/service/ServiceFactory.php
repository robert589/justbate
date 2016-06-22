<?php

namespace frontend\service;


use frontend\dao\ListNotificationDao;

class ServiceFactory {


    const LIST_NOTIFICATION_SERVICE = "list_notification_service";


    public function getService($creatorType ){

        if($creatorType === self::LIST_NOTIFICATION_SERVICE){
            return new ListNotificationService(new ListNotificationDao() );
        }
        return null;
    }
}