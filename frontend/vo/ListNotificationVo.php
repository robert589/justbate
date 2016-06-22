<?php


namespace frontend\vo;

use common\components\DateTimeFormatter;
use Yii;
use yii\data\ArrayDataProvider;

class ListNotificationVo implements Vo{

    private $list_notification;



    static function createBuilder(){
        return new ListNotificationVoBuilder();
    }

    function __construct(ListNotificationVoBuilder $builder)
    {
        $this->list_notification = $builder->getListNotification();
    }

    /**
     * @return mixed
     */
    public function getListNotificationProvider()
    {
        return  new \yii\data\ArrayDataProvider([
            'allModels' => $this->list_notification,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);;
    }


}