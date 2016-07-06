<?php

namespace frontend\controllers;

use frontend\models\UpdateUserNotifLastSeenUserForm;
use frontend\service\ServiceFactory;
use Yii;
use yii\base\View;
use yii\web\Controller;

class NotificationController extends Controller{

    /**
     * @var ServiceFactory
     */
    private $serviceFactory;

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function init() {
        $this->serviceFactory = new ServiceFactory();
    }


    public function actionIndex() {
        $service = $this->serviceFactory->getService(ServiceFactory::LIST_NOTIFICATION_SERVICE);
        $vo = $service->getNotifications(Yii::$app->user->getId());

        $form = new UpdateUserNotifLastSeenUserForm();
        $form->user_id = Yii::$app->user->getId();
        $form->update();
        return $this->renderAjax( 'index' , ['list_notification_vo' => $vo] );

    }

    public function actionCountNewNotification() {
        if(!Yii::$app->user->isGuest) {
            $service = $this->serviceFactory->getService(ServiceFactory::LIST_NOTIFICATION_SERVICE);
            $total = $service->getCountNewNotification(Yii::$app->user->getId());

            return $total;
        }
    }

}

