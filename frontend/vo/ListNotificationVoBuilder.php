<?php
namespace frontend\vo;

class ListNotificationVoBuilder implements Builder{
    private $list_notification;

    private $num_of_new_notification;

    function listNotification($list_notification){
        $this->list_notification = $list_notification;
    }


    function build(){
        return new ListNotificationVo($this);
    }

    /**
     * @return mixed
     */
    public function getListNotification()
    {
        return $this->list_notification;
    }

    /**
     * @return mixed
     */
    public function getNumOfNewNotification()
    {
        return $this->num_of_new_notification;
    }

    /**
     * @param mixed $num_of_unread_message
     */
    public function setNumOfNewNotification($num_of_new_notification)
    {
        $this->num_of_new_notification = $num_of_new_notification;
    }



}