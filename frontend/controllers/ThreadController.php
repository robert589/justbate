<?php
namespace frontend\controllers;

use app\components\ChildCommentSSE;
use common\models\ThreadIssue;
use frontend\models\CommentVoteForm;
use frontend\models\DeleteCommentForm;
use frontend\models\DeleteThreadForm;
use frontend\models\EditCommentForm;
use frontend\models\NotificationForm;
use frontend\models\SubmitRateThreadForm;
use frontend\models\SubmitThreadVoteForm;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\data\Pagination;

use frontend\models\CommentForm;
use frontend\models\ChildCommentForm;
use frontend\models\EditThreadForm;

use common\models\Comment;
use common\models\Thread;
use common\models\ThreadRate;
use common\models\Choice;
use common\models\ChildComment;
use common\models\CommentVote;

use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;
use common\models\ThreadVote;

/**
 * Profile controller
 */
class ThreadController extends Controller
{

	public function actionIndex(){

		if(!empty($_GET['id'])){

			$thread_id = $_GET['id'];
			//thread data
			$thread = Thread::retrieveThreadById($thread_id, \Yii::$app->user->getId());
			$commentModel = new CommentForm();

			//thread_issue
			$thread_issues = ThreadIssue::getIssue($thread_id);

			//get all thread_choices
			$thread_choices = Choice::getMappedChoiceAndItsVoters($thread_id);

			//get all comment providers
			$comment_providers = Comment::getAllCommentProviders($thread_id, $thread_choices);

			// get vote mdoels
			$submitVoteModel = new SubmitThreadVoteForm();

			if($thread['thread_status'] != Thread::STATUS_BANNED){
				return $this->render('index', ['model' => $thread,
											'commentModel' => $commentModel
											,'thread_choices' => $thread_choices,
											'thread_issues' => $thread_issues,
											'submitVoteModel' => $submitVoteModel,
											'comment_providers' => $comment_providers]);
			}
			else{
				return $this->render('banned');
			}
		}


		return $this->redirect(Yii::$app->request->baseUrl . '/site/error');
	}
	/*
	public function actionGetSSEChildComment(){
		if($_GET['latest_time'] && $_GET['comment_id']) {
			$comment_id = $_GET['comment_id'];
			$latest_time = $_GET['latest_time'];

			$sse = new ChildCommentSSE();

			while (1) {

				sleep(1);

				if(Comment::checkNewChildComment($comment_id, $latest_time)){
					$message = Comment::getLatestChildComment($comment_id, $latest_time);
					return $sse->sendMessage($message);
				}

				$latest_time =  time();
			}
		}
	}*/

	public function actionGetChildComment(){
		if(isset($_GET['comment_id']) && isset($_GET['thread_id'])){
			$comment_id = $_GET['comment_id'];
			$thread_id = $_GET['thread_id'];
			$result =  ChildCOmment::getAllChildCommentsByCommentId($comment_id);

			$child_comment_provider = new \yii\data\ArrayDataProvider([
				'allModels' => $result,
				'pagination' => [
					'pageSize' => 5,
				]
			]);

			$child_comment_form = new ChildCommentForm();

			$whose_comment = Comment::findOne(['comment_id' => $comment_id]);
			if(\Yii::$app->getUser()->id == $whose_comment->user_id){
				$belongs = 1;
			}
			else{

				$belongs = 0;
			}

			return $this->renderAjax('_child_comment', ['child_comment_provider' => $child_comment_provider,
												'comment_id' => $comment_id,
												'thread_id' => $thread_id,
												'belongs' => $belongs,
												'retrieved' => true,
												'child_comment_form' => $child_comment_form]);
		}

		else{
			Yii::$app->end('comment_id not poster');
		}
	}

	/**
	 * POST DATA: user_id, parent_id, ChildCommentForm
	 * return: render
	 */
	public function actionSubmitChildComment(){
		$child_comment_form = new ChildCommentForm();
		if(isset($_POST['user_id'])  && isset($_POST['parent_id'])) {
			$user_id = $_POST['user_id'];
			$parent_id = $_POST['parent_id'];

			$child_comment_form->user_id = $user_id;
			$child_comment_form->parent_id = $parent_id;

			if($child_comment_form->load(Yii::$app->request->post()) && $child_comment_form->validate()){
				if($child_comment_form->store()){
					if($this->updateChildCommentNotification($user_id, $parent_id)){

						$child_comment_form = new ChildCommentForm();
						$result =  ChildCOmment::getAllChildCommentsByCommentId($parent_id);
						$child_comment_provider = new \yii\data\ArrayDataProvider([
							'allModels' => $result,
							'pagination' => [
								'pageSize' => 5,
							]
						]);

						return $this->renderAjax('_child_comment_input_box',
							['comment_id' => $parent_id,
							'retrieved' => true,
							'child_comment_provider' => $child_comment_provider,
							'child_comment_form' => $child_comment_form]);

					}
				}
			}
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
		if(!Yii::$app->user->isGuest && isset($_POST['thread_id'])){
			$commentModel = new CommentForm();
			$thread_id = $_POST['thread_id'];
			$thread_choices = Choice::getMappedChoiceAndItsVoters($thread_id);

			if($commentModel->load(Yii::$app->request->post()) && $commentModel->validate()  ) {

				$commentModel->thread_id =  $thread_id;
				$commentModel->user_id = \Yii::$app->user->getId();
				if($comment_id = $commentModel->store()){
					if($this->updateCommentNotification($commentModel->user_id, $thread_id)){
						//$thread = Thread::findOne(['thread_id' => $thread_id]);
						$model = Comment::getCommentByCommentId($comment_id);
						$comment_vote_comment = \common\models\CommentVote::getCommentVotesOfComment($comment_id, Yii::$app->getUser()->getId());
						if (Yii::$app->user->isGuest) {
							$belongs = 0;
						}
						else {
							if(Yii::$app->user->getId()== $model['user_id']){
								$belongs = 1;
							} else {
								$belongs = 0;
							}
						}

						//return $this->render('_comment_input_box', ['thread_id' => $thread_id, 'commentModel' => $commentModel]);


						return  $this->renderAjax('_listview_comment', ['model' => $model,
										'belongs' => $belongs,
										'comment_id' => $comment_id,
										'child_comment_form' => new ChildCommentForm(),
										'total_like' => $comment_vote_comment['total_like'],
										'total_dislike' => $comment_vote_comment['total_dislike'],
										'vote' => $comment_vote_comment['vote']									]);
					}
				}
				else{
					return $this->renderAjax('_comment_input_box', ['commentModel' => $commentModel, 'thread_id' => $thread_id, 'thread_choices' => $thread_choices]);
				}
			}
		}

		return null;
	}

	/**
	 *
	 */
	public function actionCommentVote(){
		//Yii::$app->end(var_dump($_POST));
		if(isset($_POST['comment_id']) && isset($_POST['vote'])){

			$trigger_login_form = false;
			if(isset($_POST['user_id'])) {
				$comment_id = $_POST['comment_id'];
				$user_id = $_POST['user_id'];
				$vote = $_POST['vote'];


				$comment_vote_form = new CommentVoteForm();
				$comment_vote_form->user_id = $user_id;
				$comment_vote_form->vote = $vote;
				$comment_vote_form->comment_id =  $comment_id;
				if ($comment_vote_form->validate()) {
					if ($comment_vote_form->store() == true) {
					} else {
						//error if store fail
						//error if something is wrong
						if($comment_vote_form->hasErrors()){
							Yii::$app->end(var_dump($comment_vote_form->getErrors()))	;

						}
					//	Yii::$app->end('Failed to store votes');

					}
				} else {
					//error if something is wrong
					if($comment_vote_form->hasErrors()){
						Yii::$app->end(var_dump($comment_vote_form->getErrors()))	;

					}
					Yii::$app->end('Failed to validate votes');

				}
			}
			else{
				$trigger_login_form = true;
			}

			$comment_votes_comment  = CommentVote::getCommentVotesOfComment($comment_id, $user_id);
			$total_like  = $comment_votes_comment['total_like'];
			$total_dislike = $comment_votes_comment['total_dislike'];
			$vote = $comment_votes_comment['vote'];
			return $this->renderAjax('_comment_votes', ['total_like' => $total_like, 'total_dislike' => $total_dislike,
				'vote' => $vote, 'comment_id' => $comment_id, 'trigger_login_form' => $trigger_login_form]);
		}
		else{
			Yii::$app->end('helo');
		}
	}

	/**
	 * POST DATA: $_POST['userThreadRate'] and $_POST['thread_id']
	 * OTHER DATA: user_id
	 * @return bool|string
	 */
	public function actionSubmitRate(){
		if(!empty($_POST['userThreadRate']) && !empty($_POST['thread_id'])){
			$trigger_login_form = false;
			$userThreadRate = $_POST['userThreadRate'];
			$thread_id = $_POST['thread_id'];

			if(!Yii::$app->user->isGuest){
				$rateModel = new SubmitRateThreadForm();
				$rateModel->rate = $userThreadRate;
				$rateModel->thread_id = $thread_id;
				$rateModel->user_id = \Yii::$app->user->getId();

				if(!$rateModel->insertRating()){
					//db exception
					return false;
				}
			}
			else{$trigger_login_form = true;}


			$avg_rating = ThreadRate::getAverageRate($thread_id);

			$total_raters = ThreadRate::getTotalRaters($thread_id);
			return $this->renderPartial('_submit_rate_pjax', ['trigger_login_form' => $trigger_login_form,
				'thread_id' => $thread_id,'total_raters' => $total_raters, 'avg_rating' => $avg_rating ]);

		}
	}

	/**
	 * POST DATA: SubmitThreadVoteForm['choice_text'], thread_id (inserted to submitthreadvoteform)
	 * OTHER DATA: user_id (retrieved in controller)
	 * WEAKNESS: Query needs to be two times for choice, and user_vote
	 * @return string|\yii\web\Response
	 */
	public function actionSubmitVote(){
		$trigger_login_form = false;
		$thread_vote_form = new SubmitThreadVoteForm();

		if( (isset($_POST['thread_id'])) && $thread_vote_form->load(Yii::$app->request->post())) {
			$thread_id = $_POST['thread_id'];
			//only person that is looged in can submit vote
			if (!Yii::$app->user->isGuest) {
				//loading thread_vote_form
				if ((isset($_POST['thread_id'])) && $thread_vote_form->load(Yii::$app->request->post())) {
					$thread_vote_form->thread_id = $thread_id;
					//user id retrieved in controller
					$thread_vote_form->user_id = \Yii::$app->user->getId();
					if (!$thread_vote_form->submitVote()) {
						//if the submission fail
					}
				}
			}
			else {
				$trigger_login_form = true;
			}


			$submitVoteModel = new SubmitThreadVoteForm();
			$thread = Thread::retrieveThreadById($thread_id, \Yii::$app->user->getId());

			//get all thread_choices
			$thread_choices = Choice::getMappedChoiceAndItsVoters($thread_id);

			//get all comment providers
			$comment_providers = Comment::getAllCommentProviders($thread_id, $thread_choices);

			// get vote mdoels
			$submitVoteModel = new SubmitThreadVoteForm();
			return $this->renderPartial('_title_description_vote',
				['thread_choices' => $thread_choices,
					'submitVoteModel' => $submitVoteModel,
					'comment_providers' => $comment_providers,
					'user_choice' => $thread['user_choice'],
					'vote_tab_active' => true,
					'thread_id' => $thread_id,
					'title' => $thread['title'],
					'description' => $thread['description']]);
		}
		else{
			//if thread_id is not passed
		}
	}

	public function actionDeleteComment(){
		$delete_comment_form = new DeleteCommentForm();
		if(isset($_POST['comment_id'])){
			$delete_comment_form->comment_id = $_POST['comment_id'];
			if($delete_comment_form->delete()){
				$thread = Thread::findOne(['thread_id' => $_POST['thread_id']]);
				return $this->redirect(Yii::$app->request->baseUrl . '/thread/' . $_POST['thread_id'] . '/' . str_replace(' ', '-', strtolower($thread->title)));
			}
		}
	}

	public function actionDeleteThread(){
		$delete_thread_form = new DeleteThreadForm();
		if(isset($_POST['thread_id'])){
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
			return $this->render('_view_edit_comment_part', ['comment_id' => $edit_comment_form->parent_id,
															'comment' => $edit_comment_form->comment,
															'edit_comment_form'=> new EditCommentForm()]);

		}
		else{
			Yii::$app->end('error');
			//error
		}
	}

	public function actionEditThread() {

		if(Yii::$app->request->isPjax){

			$editted_thread = new EditThreadForm();

			$editted_thread->description = $_POST['description'];

			$editted_thread->title = $_POST['title'];

			$editted_thread->thread_id = $_POST['thread_id'];



			if($editted_thread->update()) {
				//thread data
				$thread = Thread::retrieveThreadById($editted_thread->thread_id, \Yii::$app->user->getId());

				//get all thread_choices
				$thread_choices = Choice::getMappedChoiceAndItsVoters($editted_thread->thread_id);

				//get all comment providers
				$comment_providers = Comment::getAllCommentProviders($editted_thread->thread_id, $thread_choices);

				// get vote mdoels
				$submitVoteModel = new SubmitThreadVoteForm();

				return $this->render('_title_description_vote',
					['thread_choices' => $thread_choices,
						'submitVoteModel' => $submitVoteModel,
						'comment_providers' => $comment_providers,
						'user_choice' => $thread['user_choice'],
						'thread_id' => $editted_thread->thread_id,
						'title' => $_POST['title'],
						'description' => $editted_thread->description]);
			}
		}
	}

	private function updateCommentNotification($trigger_id, $thread_id){
		$notification_form = new NotificationForm();
		$notification_form->trigger_id = $trigger_id;
		if($notification_form->insertCommentNotification($thread_id) == true){
			return true;
		}
	}

	private function updateChildCommentNotification($trigger_id, $comment_id){
		$notification_form = new NotificationForm();
		$notification_form->trigger_id = $trigger_id;
		if($notification_form->insertChildCommentNotification($comment_id)){
			return true;
		}
	}


}
