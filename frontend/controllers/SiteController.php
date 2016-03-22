<?php
namespace frontend\controllers;

use common\models\Issue;
use frontend\models\CreateThreadForm;
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
		$user = User::find()->where(['email' => $userAttributes['email']])->one();
		if(!empty($user)){
			Yii::$app->user->login($user);
		}
		else{
			$session = Yii::$app->session;
			$session['attributes'] =$userAttributes;

		   return $this->redirect(Url::to(['signup', 'fb' => true]));
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
		//get Issue
		if(!empty($_GET['issue'])){
			$result = Thread::getThreads($_GET['issue']);
		}
		else{
			$result = Thread::getThreads();
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

		return $this->render('home', ['issue_list' => $issue_list,
									'trending_topic_list' => $trending_topic_list,
									'list_data_provider' => $data_provider,
									'create_thread_form' => $create_thread_form]);
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

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			if(!empty($_POST['redirect_from'])){
			   $redirect_from = $_POST['redirect_from'];
			   return $this->redirect($redirect_from);
			}
			else{
				return $this->redirect(Yii::getAlias('@base-url'));
			}
		} else {
			return $this->render('login', [
				'login_form' => $model,
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


			return $this->renderAjax('_list_thread_comment_part', [
						'thread_id' => $thread_id,
						'comment_retrieved' => true,
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
		if (!is_null($q)) {
			$data = Thread::getThreadsBySearch($q);
			$out['results'] = array_values($data);
		}

		return $out;
	}

	/**
	 * Signs user up.
	 *
	 * @return mixed
	 */
	public function actionSignup()
	{

		$model = new SignupForm();

		//if it comes from facebook
		if(!empty($_GET['fb'])){
			$session = Yii::$app->session;
			$model->email = $session['attributes']['email'];
			$model->first_name = $session['attributes']['first_name'];
			$model->last_name = $session['attributes']['last_name'];
		}

		if ($model->load(Yii::$app->request->post())) {
			if ($user = $model->signup()) {
				if (Yii::$app->getUser()->login($user)) {
					return $this->redirect(Yii::$app->request->baseUrl . '/site/home');
				}
			}
		}

		return $this->render('signup', [
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


	private function getDefaultChoice(&$create_thread_form){
		$create_thread_form->choices = ['Agree','Disagree', 'Neutral'];
	}

	private function getTredingTopicList(){
		$trending_topic_list = Thread::getTop10TrendingTopic();

		$mapped_trending_topic_list = array();

		foreach($trending_topic_list as $trending_topic){
			$mapped_trending_topic['label'] = $trending_topic['title'];
			$mapped_trending_topic['url'] = Yii::$app->request->baseUrl . '/thread/index?id=' . $trending_topic['thread_id'];

			$mapped_trending_topic_list[] = $mapped_trending_topic;

		}
		return $mapped_trending_topic_list;
	}

	private function getPopularIssue(){
		$category_list = Issue::getPopularCategory();

		$mapped_category_list = array();
		foreach($category_list as $category){
			$mapped_category['label'] = $category['issue_name'];
			$mapped_category['url']  = Yii::$app->request->baseUrl . '/site/home?issue=' . $category['issue_name'];

			$mapped_category_list[] = $mapped_category;
		}


		return $mapped_category_list;
	}
}
