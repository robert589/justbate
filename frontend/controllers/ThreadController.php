<?php
namespace frontend\controllers;

use common\components\LinkConstructor;
use common\creator\CommentCreator;
use common\creator\CreatorFactory;
use common\creator\ThreadCommentCreator;
use common\creator\ThreadCreator;
use common\entity\CommentEntity;
use common\entity\ThreadCommentEntity;
use common\entity\ThreadEntity;
use common\models\ThreadAnonymous;
use frontend\models\CommentVoteForm;
use frontend\models\DeleteCommentForm;
use frontend\models\DeleteThreadForm;
use frontend\models\EditCommentForm;
use frontend\models\NotificationForm;;
use frontend\models\SubmitThreadVoteForm;
use frontend\models\ThreadAnonymousForm;

use frontend\service\ServiceFactory;
use frontend\vo\ChildCommentVo;
use frontend\vo\ChildCommentVoBuilder;
use frontend\vo\ThreadVo;
use frontend\vo\ThreadVoBuilder;
use frontend\widgets\ThreadComment;
use Yii;
use yii\web\Controller;
use frontend\models\CommentForm;
use frontend\models\ChildCommentForm;
use frontend\models\EditThreadForm;

use common\models\Thread;
/**
 * Profile controller
 */
class ThreadController extends Controller
{

	/**
	 * @var ServiceFactory
	 */
	private $serviceFactory;


	public function init() {
		$this->serviceFactory = new ServiceFactory();
	}

	/**
	 * @return string|\yii\web\Response
	 */
	public function actionIndex(){
		/** @var ThreadVo $thread */

		if(empty($_GET['id'])) {
			return $this->redirect(Yii::$app->request->baseUrl . '/site/error');
		}
		$service = $this->serviceFactory->getService(ServiceFactory::THREAD_SERVICE);
		$thread = $service->getThreadInfo( $_GET['id'],Yii::$app->user->getId(), new ThreadVoBuilder());
		$commentModel = new CommentForm();
		// get vote mdoels
		$submit_vote_form = new SubmitThreadVoteForm();

		$this->setMetaTag($thread->getThreadId(),
						  $thread->getTitle(),
						  $thread->getDescription());
		if($thread->getThreadStatus() === Thread::STATUS_BANNED) {
			return $this->render('banned');
		}
		return $this->render('index', ['thread' => $thread,
			                           'comment_model' => $commentModel,
									   'submit_vote_form' => $submit_vote_form,
		                               ]);


	}


	/**
	 * @return string
	 * @throws \yii\base\ExitException
	 */
	public function actionGetChildComment(){
		if(!(isset($_GET['comment_id']) && isset($_GET['thread_id']))) {
			Yii::$app->end('comment_id not poster');
		}

		$comment_id = $_GET['comment_id'];

		$thread_id = $_GET['thread_id'];

		$thread_comment = new ThreadCommentEntity($comment_id, Yii::$app->user->getId());

		$creator = (new CreatorFactory())->getCreator(CreatorFactory::THREAD_COMMENT_CREATOR, $thread_comment);
		/** remove this in the future for comment info, bad practice */
		$thread_comment = $creator->get([ThreadCommentCreator::NEED_CHILD_COMMENTS, ThreadCommentCreator::NEED_COMMENT_INFO]);
		$thread_comment->setThreadId($thread_id);
		$child_comment_form = new ChildCommentForm();
		return $this->renderAjax('_child_comment', ['thread_comment' => $thread_comment,
											'retrieved' => true,
											'is_thread_comment' => false,
											'child_comment_form' => $child_comment_form]);

	}

	public function actionStartServer() {
		return $this->render('child-comment-server', ['comment_id' => $_GET['comment_id']]);
	}


	/**
	 * @return string
	 * @throws \yii\base\ExitException
	 */
	public function actionRetrieveCommentInput(){
		if(!(isset($_POST['thread_id']) && Yii::$app->request->isPjax)) {
			Yii::$app->end('Something went wrong, we will fix it as soon as possible');
		}
		$service = $this->serviceFactory->getService(ServiceFactory::THREAD_SERVICE);
		$thread = $service->getThreadInfoForRetrieveCommentInput( $_POST['thread_id'],Yii::$app->user->getId(), new ThreadVoBuilder());


		return $this->renderAjax('../thread/_comment_input_box',
			['thread' => $thread,
				'comment_input_retrieved' => true,
				'comment_model' => new CommentForm()]);


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



			return $this->renderAjax('child-comment',
				['comment_id' => $parent_id,
				'retrieved' => true,
				'child_comment_form' => new ChildCommentForm(),
				'last_comment_id_current_user' => $new_comment_id ]);

		}
		else{
			return $this->renderAjax('error');
		}

	}


	/**
	 * WEAKNESS: If server validation error occur, no solution other than saying error
	 * POST DATA: Comment Model;
	 */
	public function actionSubmitComment(){
		if(Yii::$app->user->isGuest || !isset($_POST['thread_id'])) {
			Yii::$app->end('You should login before submitting the comment');
		}

		$comment_model = new CommentForm();
		$thread_id = $_POST['thread_id'];
		$thread_entity = new ThreadEntity($thread_id, Yii::$app->user->getId());
		$creator = (new CreatorFactory())->getCreator(CreatorFactory::THREAD_CREATOR, $thread_entity);
		$thread_entity = $creator->get([ThreadCreator::NEED_THREAD_CHOICE]);
		if(!($comment_model->load(Yii::$app->request->post()) && $comment_model->validate())) {
			return $this->renderAjax('_comment_input_box', ['commentModel' => $comment_model, 'thread' => $thread_entity]);
		}
		$comment_model->thread_id =  $thread_id;
		$comment_model->user_id = \Yii::$app->user->getId();
		if(!($comment_id = $comment_model->store())) {
		}
		if(!$this->updateCommentNotification($comment_model->user_id, $thread_id)){
		}
		$comment_entity = new ThreadCommentEntity($comment_id, $comment_model->user_id);
		$creator = (new CreatorFactory())->getCreator(CreatorFactory::THREAD_COMMENT_CREATOR, $comment_entity);
		$comment_entity = $creator->get([ThreadCommentCreator::NEED_COMMENT_INFO,
										 ThreadCommentCreator::NEED_COMMENT_VOTE]);
		return  $this->renderAjax('_listview_comment', [
			'thread_comment' => $comment_entity,
			'child_comment_form' => new ChildCommentForm()]);
	}

	private function setMetaTag($thread_id, $thread_title, $thread_description){
		\Yii::$app->view->registerMetaTag([
			'property' => 'og:type',
			'content' => 'website'
		]);
		\Yii::$app->view->registerMetaTag([
			'property' => 'og:image',
			'content' => 'http://www.justbate.com/frontend/web/img/logo_square_share.jpg'
		]);
		\Yii::$app->view->registerMetaTag([
			'property' => 'og:url',
			'content' => LinkConstructor::threadLinkConstructor($thread_id,$thread_title)
		]);
		\Yii::$app->view->registerMetaTag([
			'property' => 'og:title',
			'content' => $thread_title
		]);
	}

	/**
	 *
	 */
	public function actionCommentVote(){
		//Yii::$app->end(var_dump($_POST));
		if(!(isset($_POST['comment_id']) && isset($_POST['vote']) && isset($_POST['is_thread_comment']))) {
			Yii::$app->end('Fail to like: Contact Admin');
		}

		if(!isset($_POST['user_id'])) {
			$trigger_login_form = true;
		}

		$trigger_login_form = false;

		$comment_vote_form = new CommentVoteForm();
		$comment_vote_form->user_id = $_POST['user_id'];
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
		return $this->renderAjax('_comment_votes',
			['comment' => $comment_entity,
			'trigger_login_form' => $trigger_login_form,
			'is_thread_comment' => $_POST['is_thread_comment']]);
	}

	/**
	 * @return string
	 * @throws \yii\base\ExitException
	 */
	public function actionSubmitVote() {
		$submit_thread_vote_form  = new SubmitThreadVoteForm();
		$submit_thread_vote_form->user_id = Yii::$app->user->getId();
		$service = $this->serviceFactory->getService(ServiceFactory::THREAD_SERVICE);
		if($submit_thread_vote_form->load(Yii::$app->request->post()) && $submit_thread_vote_form->validate()) {
			if(!$submit_thread_vote_form->submitVote()){
				Yii::$app->end("Failed to store votes, please try again later ");
			}
		}
		$thread = $service->getThreadInfoVote( $submit_thread_vote_form->thread_id,Yii::$app->user->getId(), new ThreadVoBuilder());
		return $this->renderAjax('../thread/_thread_vote',
			['thread' => $thread, 'submit_thread_vote_form' => new SubmitThreadVoteForm()]);

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
	 * @return \yii\web\Response
	 */
	public function actionDeleteThread(){
		if(isset($_POST['thread_id'])){
			$delete_thread_form = new DeleteThreadForm();

			$delete_thread_form->thread_id = $_POST['thread_id'];

			if($delete_thread_form->delete()){
				return $this->redirect(Yii::$app->request->baseUrl . '/site/home');
			}
		}
	}

	/**
	 * POST DATA: Edit comment form (but only parent id filled), and comment
	 * CONCERN: There is a weakness in the redactor that cannot use form to store data
	 */
	public function actionEditComment(){
		$edit_comment_form = new EditCommentForm();
		$edit_comment_form->load(Yii::$app->request->post());

		if(isset($_POST['comment']) ){
			$edit_comment_form->comment = $_POST['comment'];

			$edit_comment_form->update();

			$comment_entity = new CommentEntity($edit_comment_form->parent_id, \Yii::$app->user->getId());
			$comment_entity->setComment($edit_comment_form->comment);
			return $this->render('_view_edit_comment_part', [
															'thread_comment' => $comment_entity,
															'edit_comment_form'=> new EditCommentForm()]);

		}
		else{
			Yii::$app->end('error');
			//error
		}
	}

	/**
	 * @return string
	 */
	public function actionEditThread() {
		if(Yii::$app->request->isPjax){
			$edit_thread_form = new EditThreadForm();
			if($edit_thread_form->load(Yii::$app->request->post()) && $edit_thread_form->validate()){
				if(!$edit_thread_form->update()) {
					//FAIL
				}
			}


			//thread data
			$thread_entity = new ThreadEntity($edit_thread_form->thread_id, Yii::$app->user->getId());
			$creator = (new CreatorFactory())->getCreator(CreatorFactory::THREAD_CREATOR, $thread_entity);
			$thread_entity = $creator->get([ThreadCreator::NEED_THREAD_CHOICE, ThreadCreator::NEED_USER_CHOICE_ON_THREAD_ONLY,
				ThreadCreator::NEED_THREAD_ISSUE
			]);
			$thread_entity->setTitle($edit_thread_form->title);
			$thread_entity->setDescription($edit_thread_form->description);
			//get all comment providers
			// get vote mdoels
			$submit_vote_form = new SubmitThreadVoteForm();
			return $this->renderAjax('_title_description_vote',
				['thread' => $thread_entity,
					'edit_thread_form' => $edit_thread_form,
					'submit_vote_form' => $submit_vote_form]);
		}
	}

	/**
	 * @param $trigger_id
	 * @param $thread_id
	 * @return bool
	 */
	private function updateCommentNotification($actor_id, $thread_id){
		$notification_form = new NotificationForm();
		$notification_form->actor_id = $actor_id;
		if($notification_form->submitCommentNotification($thread_id) == true){
			return true;
		}
	}

	private function updateChildCommentNotification($actor_id, $thread_id, $comment_id){
		$notification_form = new NotificationForm();
		$notification_form->actor_id = $actor_id;
		if($notification_form->submitChildCommentNotification($thread_id, $comment_id) == true){
			return true;
		}

	}

	public function actionRequestAnonymous(){
		if(isset($_POST['thread_id']) && isset($_POST['user_id'])){
			$thread_id = $_POST['thread_id'];
			$user_id = $_POST['user_id'];

			//bad practice, please remove during refactoring
			$thread_anon_form = new ThreadAnonymousForm();
			$thread_anon_form->thread_id = $thread_id;
			$thread_anon_form->user_id = $user_id;
			return $thread_anon_form->requestAnon();
		}
	}


	public function actionCancelAnonymous(){
		if(isset($_POST['thread_id']) && isset($_POST['user_id'])){
			$thread_id = $_POST['thread_id'];
			$user_id = $_POST['user_id'];

			//bad practice, please remove during refactoring
			$thread_anon_form = new ThreadAnonymousForm();
			$thread_anon_form->thread_id = $thread_id;
			$thread_anon_form->user_id = $user_id;
			return $thread_anon_form->cancelAnon();
		}
	}


}
