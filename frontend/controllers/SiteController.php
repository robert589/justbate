<?php
namespace frontend\controllers;

use common\models\Issue;
use common\models\ThreadComment;
use common\models\ThreadVote;
use frontend\models\ChangeEmailForm;
use frontend\models\CreateThreadForm;
use frontend\models\ResendChangeEmailForm;
use frontend\models\SubmitThreadVoteForm;
use frontend\models\UploadProfilePicForm;
use frontend\models\ValidateAccountForm;
use Yii;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use common\models\LoginForm;
use common\models\Thread;
use common\models\Choice;
use common\models\Comment;
use common\models\User;
use common\models\FollowerRelation;
use frontend\models\ContactForm;
use frontend\models\FilterHomeForm;
use yii\authclient\ClientInterface;
use yii\base\InvalidParamException;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

/**
 * Site controller
 */
class SiteController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['logout', 'signup'],
				'rules' => [
					[
						'actions' => ['signup'],
						'allow' => true,
						'roles' => ['?'],
					],
					[
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
			'auth' => [
				'class' => 'yii\authclient\AuthAction',
				'successCallback' => [$this, 'oAuthSuccess'],
			],
		];
	}

	/**
	 * This function will be triggered when user is successfuly authenticated using some oAuth client.
	 *
	 * @param yii\authclient\ClientInterface $client
	 * @return boolean|yii\web\Response
	 */
	public function oAuthSuccess($client) {
		// get user data from client
		$userAttributes = $client->getUserAttributes();

		// do some thing with user data. for example with $userAttributes['email']
		if(!empty($user)){
			Yii::$app->user->login($user);
		}
		else{
			$model = new SignupForm();
			$model->facebook_id = $userAttributes['id'];
			$model->first_name = $userAttributes['first_name'];
			$model->last_name = $userAttributes['last_name'];
			$url = "https://graph.facebook.com/". $userAttributes['id'] . "/picture?width=150";
			$photos = file_get_contents($url);
			$model->photo_path = (new UploadProfilePicForm())->uploadFacebookPhoto($photos);

			if($user = $model->signup()){
				Yii::$app->getUser()->login($user);
			}
		}
	}

	/**
	 * Displays homepage.
	 *
	 * @return mixed
	 */
	public function actionIndex()
	{
		return $this->redirect('site/home');
	}

	/**
	* Generate Home page include Trending Issue, Trending Topic, and newest Topic
	*/
	public function actionHome()
	{
		if(Yii::$app->user->isGuest){
			return $this->render('login',
				[
					'login_form' => new LoginForm(),
					'model' => new SignupForm()
				]);
		}

		$user_id = Yii::$app->user->getId();

		//get Issue
		if(!empty($_GET['issue'])){
			$result = Thread::getThreads($user_id, $_GET['issue']);

		}
		else{
			$result = Thread::getThreads($user_id);
		}

		$data_provider = new ArrayDataProvider([
			'allModels' => $result,
			'pagination' => [
				'pageSize' =>10,
			],
		]);

		//Create form
		$create_thread_form  = new CreateThreadForm();
		$this->getDefaultChoice($create_thread_form);

		//retrieve trending topic
		$trending_topic_list = $this->getTredingTopicList();

		//get popular category
		$issue_list = $this->getPopularIssue();

		//check whether he/she has validated her email
		$user = User::findOne(['id' => $user_id]);

		$change_email_form = new ResendChangeEmailForm();
		if($user->email != ''){
			$change_email_form->user_email = $user->email;
		}

		return $this->render('home', ['issue_list' => $issue_list,
									'trending_topic_list' => $trending_topic_list,
									'list_data_provider' => $data_provider,
									'user' => $user,
									'change_email_form' => $change_email_form,
									'create_thread_form' => $create_thread_form]);
	}

	public function actionChangeVerifyEmail(){

		$change_email_form = new ResendChangeEmailForm();
		if($change_email_form->load(Yii::$app->request->post()) && $change_email_form->validate()){
			if($change_email_form->change()){
				return $this->renderPartial('_home_verify-email', [
					'change_email_form'=> $change_email_form,
					'message' => '']);
			}

		}
		else{
			if($change_email_form->hasErrors()){
				$message = $change_email_form->getErrors()[0];
			}
			else{
				$message = 'Failed to change/resend email';
			}
		}
		return $this->renderPartial('_home_verify-email', [
			'change_email_form' => $change_email_form,
			'message' => $message]);

	}

	public function actionFollowee() {
		if(\Yii::$app->user->isGuest) {
			return $this->render('login');
		}

		//initial data without filter
		$result = Thread::retrieveThreadFromFollowee(\Yii::$app->user->id);

		$dataProvider = new ArrayDataProvider([
			'allModels' => $result,
			'pagination' => [
				'pageSize' =>10,
			],

		]);

		//Create form
		$create_thread_form  = new CreateThreadForm();
		$this->getDefaultChoice($create_thread_form);
		//retrieve trending topic
		$trending_topic_list = $this->getTredingTopicList();

		//get popular category
		$issue_list = $this->getPopularIssue();

		return $this->render('home', ['issue_list' => $issue_list,
									'trending_topic_list' => $trending_topic_list,
									'listDataProvider' => $dataProvider,
									'create_thread_form' => $create_thread_form]);
	}

	/**
	 * Logs in a user.
	 *
	 * @return mixed
	 */
	public function actionLogin()
	{
		if (!\Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		$model = new SignupForm();


		$login_model = new LoginForm();
		if ($login_model->load(Yii::$app->request->post()) && $login_model->login()) {
			return $this->redirect(Yii::$app->request->baseUrl);
		}
		else {
			return $this->render('login', [
				'login_form' => $login_model,
				'model' => $model
			]);
		}
	}

	/**
	 *
	 */
	public function actionGetComment(){
		if(!empty($_POST['thread_id']) && Yii::$app->request->isPjax){
			$thread_id = $_POST['thread_id'];

			//get all thread_choices
			$thread_choices = Choice::getMappedChoiceAndItsVoters($thread_id);
			//get all comment providers
			$comment_providers = Comment::getAllCommentProviders($thread_id, $thread_choices);

			$total_comments = ThreadComment::getTotalThreadComments($thread_id);

			return $this->render('_list_thread_thread_comment', [
						'thread_id' => $thread_id,
						'comment_retrieved' => true,
						'total_comments' => $total_comments,
						'thread_choices' => $thread_choices,
						'comment_providers' => $comment_providers]);
		}
		else{
			return $this->redirect(Yii::$app->request->baseUrl . '/site/error');
		}
	}

	/**
	 * Logs out the current user.
	 *
	 * @return mixed
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}

	/**
	 * Create thread
	 *
	 * @return string|\yii\web\Response
	 * @throws \yii\base\ExitException
	 */
	public function actionCreateThread(){
		$create_thread_form = new CreateThreadForm();
		$create_thread_form->user_id = Yii::$app->user->getId();

		if($create_thread_form->load(Yii::$app->request->post()) && $create_thread_form->validate()){
			if($thread_id = $create_thread_form->create()){
				return $this->redirect(Yii::$app->request->baseUrl . '/thread/index?id=' . $thread_id);
			}
		}
		else{
			Yii::$app->end(print_r($create_thread_form->getErrors()));
		}

		return $this->renderAjax('home', ['create_thread_form' => $create_thread_form]);
	}

	/**
	 * Displays contact page.
	 *
	 * @return mixed
	 */
	public function actionContact()
	{
		$model = new ContactForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
				Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
			} else {
				Yii::$app->session->setFlash('error', 'There was an error sending email.');
			}

			return $this->refresh();
		} else {
			return $this->render('contact', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Displays about page.
	 *
	 * @return mixed
	 */
	public function actionAbout()
	{
		return $this->render('about');
	}

	public function actionEditInterest(){
		return $this->render('edit-interest');
	}

	public function actionSearchInNotif($q = null){
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$out = ['results' => ['id' => '', 'text' => '']];
		if ($q != null || $q != '') {
			$data = Thread::getThreadBySearch($q);
			$out['results'] = array_values($data);
		}

		echo Json::encode($out);
	}

	/**
	 * Signs user up.
	 *
	 * @return mixed
	 */
	public function actionSignup()
	{
		$model = new SignupForm();
		$is_sign_up_with_fb = false;
		/*
		//if it comes from facebook
		if(!empty($_GET['fb'])){
			$is_sign_up_with_fb = true;

			$session = Yii::$app->session;

			if(isset($session['attributes']['email'])){
				$model->email = $session['attributes']['email'];
			}
			$model->facebook_id = $session['attributes']['id'];
			$model->first_name = $session['attributes']['first_name'];
			$model->last_name = $session['attributes']['last_name'];
			$url = "https://graph.facebook.com/". $session['attributes']['id'] . "/picture?width=150";
			$photos = file_get_contents($url);
			$model->photo_path = (new UploadProfilePicForm())->uploadFacebookPhoto($photos);
		}
		*/

		if ($model->load(Yii::$app->request->post())) {
			if ($user = $model->signup()) {
				if (Yii::$app->getUser()->login($user)) {
					return $this->redirect(Yii::$app->request->baseUrl . '/site/home');
				}
				else{
					Yii::$app->end("User" . print_r($user));
				}
			}
			else{
				Yii::$app->end("Model error: " . var_dump($user));

			}
		}

		return $this->render('signup', [
			'is_sign_up_with_fb' => $is_sign_up_with_fb,
			'model' => $model,
		]);
	}

	/**
	 * Requests password reset.
	 *
	 * @return mixed
	 */
	public function actionRequestPasswordReset()
	{
		$model = new PasswordResetRequestForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if ($model->sendEmail()) {
				Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

				return $this->goHome();
			} else {
				Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
			}
		}

		return $this->render('requestPasswordResetToken', [
			'model' => $model,
		]);
	}

	/**
	 * Resets password.
	 *
	 * @param string $token
	 * @return mixed
	 * @throws BadRequestHttpException
	 */
	public function actionResetPassword($token)
	{
		try {
			$model = new ResetPasswordForm($token);
		} catch (InvalidParamException $e) {
			throw new BadRequestHttpException($e->getMessage());
		}

		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
			Yii::$app->session->setFlash('success', 'New password was saved.');

			return $this->goHome();
		}

		return $this->render('resetPassword', [
			'model' => $model,
		]);
	}


	public function actionValidateAccount(){
		if(isset($_GET['token'])){
			$model = new ValidateAccountForm();
			$model->user_id = \Yii::$app->user->getId();
			$model->code = $_GET['token'];
			if($model->validateAccount() == true){
				return $this->goHome();
			}
			else{
				Yii::$app->end('Code is not recognized');
				//error
			}
		}else{
			Yii::$app->end("No token given");
		}
	}

	public function actionIssueList(){
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$out = ['results' => ['id' => '', 'text' => '']];
		if (!empty($_GET['q'])) {
			$q = $_GET['q'];
			$topicList = Issue::getIssueList($q);
			$out['results'] = array_values($topicList);
		}

		return $out;
	}

	public function actionSubmitVote() {
		if(isset($_POST['thread_id']) && isset($_POST['user_id']) && isset($_POST['user_vote'])){

			$model  = new SubmitThreadVoteForm();
			$model->thread_id = $_POST['thread_id'];
			$model->user_id = $_POST['user_id'];
			$model->choice_text = $_POST['user_vote'];

			if($model->validate() && $model->submitVote()){

				$thread_choice_text = \common\models\Choice::getChoice($model->thread_id);

				return $this->render('_list_thread_thread_vote',
					['thread_choice_text' => $thread_choice_text,
						'thread_id' => $model->thread_id,
						'user_choice_text' => ThreadVote::find()->where(['thread_id' => $model->thread_id])
												->andWhere(['user_id' => $model->user_id])
												->one()->choice_text
					]);
			}
			else{
				if($model->hasErrors()){
					Yii::$app->end(print_r($model->getErrors()));

				}
			}
		}
		else{
			Yii::$app->end(var_dump($_POST));
		}
	}


	private function getDefaultChoice(&$create_thread_form){
		$create_thread_form->choices = ['Agree','Disagree', 'Neutral'];
	}

	private function getTredingTopicList(){
		$trending_topic_list = Thread::getTop10TrendingTopic();

		$mapped_trending_topic_list = array();

		foreach($trending_topic_list as $trending_topic){
			$mapped_trending_topic['label'] = $trending_topic['title'];
			$mapped_trending_topic['url'] = Yii::$app->request->baseUrl . '/thread/' . $trending_topic['thread_id']. '/'
				. str_replace(' ', '-' , strtolower($trending_topic['title']));

			$mapped_trending_topic_list[] = $mapped_trending_topic;

		}
		return $mapped_trending_topic_list;
	}

	private function getPopularIssue(){
		$category_list = Issue::getPopularCategory();

		$mapped_category_list = array();
		foreach($category_list as $category){
			$mapped_category['label'] = $category['issue_name'];
			$mapped_category['url']  = Yii::$app->request->baseUrl . '/issue/' . $category['issue_name'];

			$mapped_category_list[] = $mapped_category;
		}


		return $mapped_category_list;
	}
}
