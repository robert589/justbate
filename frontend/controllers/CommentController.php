<?php

namespace frontend\controllers;

use common\creator\CommentCreator;
use common\creator\CreatorFactory;
use common\creator\ThreadCommentCreator;
use common\entity\ChildCommentVo;
use common\entity\ThreadCommentEntity;
use common\models\Thread;
use common\models\ThreadComment;
use frontend\models\ChildCommentForm;
use frontend\models\CommentVoteForm;
use frontend\models\DeleteCommentForm;
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
                if($vo->getCommentStatus() == 0){
                    return $this->render('comment-deleted');
                }
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

            $thread_id = ThreadComment::findOne(['comment_id' => $parent_id])->thread_id;
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

    public function actionGetChildComment(){
        if(!(isset($_GET['comment_id']) && isset($_GET['thread_id']))) {
            Yii::$app->end('comment_id not poster');
        }
        $comment_id = $_GET['comment_id'];
        $thread_id = $_GET['thread_id'];
        $service = $this->serviceFactory->getService(ServiceFactory::COMMENT_SERVICE);
        $vo  = $service->getChildCommentList(Yii::$app->user->getId(), $comment_id, $thread_id);
        $child_comment_form = new ChildCommentForm();
        return $this->render('child-comment-list', ['thread_comment' => $vo,
            'retrieved' => true,
            'is_thread_comment' => false,
            'child_comment_form' => $child_comment_form]);

    }

    /**
     * @ajax
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionGetNewChildComment() {
        if(!(isset($_GET['comment_id']))) {
            Yii::$app->end('comment_id not poster');
        }
        $comment_id = $_GET['comment_id'];
        $service = $this->serviceFactory->getService(ServiceFactory::COMMENT_SERVICE);
        $thread_comment_vo  = $service->getNewChildCommentList(Yii::$app->user->getId(), $comment_id, $_GET['page'], $_GET['per-page']);
        $child_comment_vos = $thread_comment_vo->getChildCommentList();
        $view ="";
        foreach($child_comment_vos->getModels() as $child_comment) {
            $view .= $this->renderPartial('child-comment', ['child_comment' => $child_comment]);
        }
        return $view;
    }


    /**
     * @return \yii\web\Response
     */
    public function actionDeleteComment(){
        if(isset($_POST['comment_id'])){
            $delete_comment_form = new DeleteCommentForm();
            $delete_comment_form->comment_id = $_POST['comment_id'];
            if($delete_comment_form->delete()){
                $thread = Thread::findOne(['thread_id' => $_POST['thread_id']]);
                return $this->redirect(Yii::$app->request->baseUrl . '/thread/' . $_POST['thread_id'] . '/' . str_replace(' ', '-', strtolower($thread->title)));
            }
        }
    }

    /**
     *
     */
    public function actionCommentVote(){
        //Yii::$app->end(var_dump($_POST));
        if(!(isset($_POST['comment_id']) && isset($_POST['vote']))) {
            Yii::$app->end('Fail to like: Contact Admin');
        }
        $comment_vote_form = new CommentVoteForm();
        $comment_vote_form->user_id = Yii::$app->user->getId();
        $comment_vote_form->vote = $_POST['vote'];
        $comment_vote_form->comment_id =  $_POST['comment_id'];
        if (!$comment_vote_form->validate()) {
            return false;
        }
        if ($comment_vote_form->store() !== true) {
            return false;
        }
        return true;
    }

    public function actionChildCommentVote() {
        //Yii::$app->end(var_dump($_POST));
        if(!(isset($_POST['comment_id']) && isset($_POST['vote']) && isset($_POST['is_thread_comment']))) {
            Yii::$app->end('Fail to like: Contact Admin');
        }

        $trigger_login_form = false;
        $comment_vote_form = new CommentVoteForm();
        $comment_vote_form->user_id = Yii::$app->user->getId();
        $comment_vote_form->vote = $_POST['vote'];
        $comment_vote_form->comment_id =  $_POST['comment_id'];

        if (!$comment_vote_form->validate()) {
            Yii::$app->end('Failed to validate votes');
        }

        if ($comment_vote_form->store() !== true) {
            Yii::$app->end('Failed to store votes');
        }
        //use thread comment entity, although it is child comment entity
        //bad practice, use it for a while

        $comment_entity = new ThreadCommentEntity($comment_vote_form->comment_id, $comment_vote_form->user_id);
        $creator = (new CreatorFactory())->getCreator(CreatorFactory::THREAD_COMMENT_CREATOR, $comment_entity);
        $comment_entity =$creator->get([CommentCreator::NEED_COMMENT_VOTE]);
        return $this->renderAjax('child-comment-votes',
            ['comment' => $comment_entity,
                'trigger_login_form' => $trigger_login_form,
                'is_thread_comment' => $_POST['is_thread_comment']]);
    }


}

