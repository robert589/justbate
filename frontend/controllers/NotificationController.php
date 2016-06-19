<?php

namespace frontend\controllers;


use frontend\models\TagInThread;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\data\SqlDataProvider;
use yii\data\Pagination;
use yii\helpers\Url;
use frontend\models\ThreadTopic;
use frontend\models\CreateThreadForm;
use common\models\User;
use common\models\Notification;
class NotificationController extends Controller{

    public function actionIndex(){
        //Leave it first
        $recentActivity = Notification::getAllNotifications(\Yii::$app->user->getId());

        // build an ArrayDataProvider with an empty query and a pagination with 40 items for page
        $recentActivity = new \yii\data\ArrayDataProvider([
            'allModels' => $recentActivity,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        //remve the base line
        return $this->renderAjax( 'index' , ['recent_notifications_provider' => $recentActivity] );

    }



}

