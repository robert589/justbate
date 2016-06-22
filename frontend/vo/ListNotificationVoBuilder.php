<?php
namespace frontend\vo;

class ListNotificationVoBuilder implements Builder{
    private $list_notification;

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


}