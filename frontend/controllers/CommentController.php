<?php

namespace frontend\controllers;

use common\entity\ChildCommentVo;
use frontend\models\ChildCommentForm;
use frontend\models\NotificationForm;
use frontend\service\ServiceFactory;
use frontend\vo\ThreadCommentVo;
use Yii;
use yii\web\Controller;

class CommentController extends Controller{

    /**
     * @var ServiceFactory
     */
    private $serviceFactory;

    public function init() {
        $this->serviceFactory = new ServiceFactory();
    }


    public function actionIndex(){
        if(isset($_GET['comment_id']) && isset($_GET['id'])){
            $service = $this->serviceFactory->getService(ServiceFactory::COMMENT_SERVICE);
            $vo = $service->getThreadCommentInfo(Yii::$app->user->getId(), $_GET['id'], $_GET['comment_id']);
            if($vo === null){
                return $this->redirect(Yii::$app->request->baseUrl . '/site/not-found');
            }
            else if($vo instanceof ThreadCommentVo){
                return $this->render('index', ['thread_comment' => $vo] );
            }
        }
    }


    /**
     * POST DATA: user_id, parent_id, ChildCommentForm
     * return: render
     */
    public function actionSubmitChildComment() {
        $child_comment_form = new ChildCommentForm();
        if(isset($_POST['user_id'])  && isset($_POST['parent_id'])) {
            $user_id = $_POST['user_id'];
            $parent_id = $_POST['parent_id'];
            $child_comment_form->user_id = $user_id;
            $child_comment_form->parent_id = $parent_id;
            if(!($child_comment_form->load(Yii::$app->request->post()) && $child_comment_form->validate())){
                //error
            }
            //bad practice
            $thread_id = \common\models\ThreadComment::findOne(['comment_id' => $parent_id])->thread_id;

            if(!$this->updateChildCommentNotification($child_comment_form->user_id, $thread_id, $parent_id)){
                //error
            }

            if(!($new_comment_id = $child_comment_form->store())){
                //error
            }

            $service = $this->serviceFactory->getService(ServiceFactory::COMMENT_SERVICE);
            $vo  = $service->getChildCommentInfo($user_id, $new_comment_id);


            return $this->renderAjax('child-comment',
                ['child_comment' => $vo
                ]);

        }
        else{
            return $this->renderAjax('error');
        }

    }

    private function updateChildCommentNotification($actor_id, $thread_id, $comment_id){
        $notification_form = new NotificationForm();
        $notification_form->actor_id = $actor_id;
        if($notification_form->submitChildCommentNotification($thread_id, $comment_id) == true){
            return true;
        }

    }




}

