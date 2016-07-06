<?php
namespace frontend\service;

use frontend\dao\ListNotificationDao;
use frontend\vo\ListNotificationVoBuilder;

class ListNotificationService{

    private $list_notification_dao;

    function __construct(ListNotificationDao $list_notification_dao)
    {
        $this->list_notification_dao = $list_notification_dao;
    }

    public function getNotifications($user_id){
        $builder = new ListNotificationVoBuilder();
        $this->list_notification_dao->buildListNotification($user_id, $builder);
        return $builder->build();
    }

    public function getCountNewNotification($user_id) {
        return $this->list_notification_dao->getNumOfNewNotification($user_id);
    }

}