<?php

namespace frontend\controllers;

use frontend\service\ServiceFactory;
use Yii;
use yii\web\Controller;

class NotificationController extends Controller{

    /**
     * @var ServiceFactory
     */
    private $serviceFactory;

    public function init() {
        $this->serviceFactory = new ServiceFactory();
    }


    public function actionIndex(){

        $service = $this->serviceFactory->getService(ServiceFactory::LIST_NOTIFICATION_SERVICE);

        $vo = $service->getNotifications(Yii::$app->user->getId());
        return $this->renderAjax( 'index' , ['list_notification_vo' => $vo] );

    }



}

