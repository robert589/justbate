<?php
namespace frontend\controllers;

use common\components\LinkConstructor;
use common\creator\CreatorFactory;
use common\creator\ThreadCreator;
use common\entity\ThreadEntity;
use common\models\Issue;
use yii\widgets\ActiveForm;
use frontend\models\EditUserIssueForm;
use common\models\UserFollowedIssue;
use frontend\models\CreateThreadForm;
use frontend\models\ResendChangeEmailForm;
use frontend\models\UploadProfilePicForm;
use frontend\models\UserFollowIssueForm;
use frontend\models\ValidateAccountForm;
use frontend\service\ServiceFactory;
use frontend\vo\SiteVoBuilder;
use Yii;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use common\models\LoginForm;
use common\models\Thread;
use common\models\Choice;
use common\models\Comment;
use common\models\User;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
	/**
	 * @var ServiceFactory
	 */
	private $serviceFactory;

	public function init() {
            $this->serviceFactory = new ServiceFactory();
	}

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
		if(User::find()->where(['facebook_id' => $userAttributes['id']])->exists()){
			$user = User::find()->where(['facebook_id' => $userAttributes['id']])->one();
			Yii::$app->user->login($user,3600 * 24 * 30 );
		}
		else{
			$model = new SignupForm();
			$model->facebook_id = $userAttributes['id'];
			$model->first_name = $userAttributes['first_name'];
			$model->last_name = $userAttributes['last_name'];
			$url = "https://graph.facebook.com/". $userAttributes['id'] . "/picture?width=150";
			$arrContextOptions=array(
				"ssl"=>array(
					"verify_peer"=>false,
					"verify_peer_name"=>false,
				),
			);
			$photos = file_get_contents($url, false, stream_context_create($arrContextOptions));
			$model->photo_path = (new UploadProfilePicForm())->uploadFacebookPhoto($photos);

			if($user = $model->signup()){
				Yii::$app->getUser()->login($user, 3600 * 24 * 30);
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
	* Generate Home page include Followed Issue, Trending Topic, and newest Topic

         **/
	public function actionHome()
	{
            $this->setMetaTag();
    
            $user_id = Yii::$app->user->getId();
            $issue = isset($_GET['issue']) ? $_GET['issue'] : null;
            $service = $this->serviceFactory->getService(ServiceFactory::SITE_SERVICE);
            $home = $service->getHomeInfo($user_id, $issue, new SiteVoBuilder());
            $create_thread_form = new CreateThreadForm();
            $selected = $home->getHomeSelected();
            return $this->render('home', ['home' => $home,
                                            'feed_selected' => $selected,
                                          'change_email_form' => new ResendChangeEmailForm(),
                                          'create_thread_form' => $create_thread_form]);
	}
        
        public function actionNew() {
            $user_id = Yii::$app->user->getId();
            $issue = isset($_GET['issue']) ? $_GET['issue'] : null;
            $service = $this->serviceFactory->getService(ServiceFactory::SITE_SERVICE);
            $home = $service->getNewestThread($user_id, new SiteVoBuilder());
            $create_thread_form = new CreateThreadForm();
            return $this->render('home', ['home' => $home,
                                        'feed_selected' => $home->getNewestTopicSelected(),
                                          'change_email_form' => new ResendChangeEmailForm(),
                                          'create_thread_form' => $create_thread_form]);
	    
        }

	/**
	 *
	 */
	private function setMetaTag(){

		\Yii::$app->view->registerMetaTag([
			'property' => 'og:type',
			'content' => 'website'
		]);
		\Yii::$app->view->registerMetaTag([
			'property' => 'og:image',
			'content' =>  'http://www.justbate.com/frontend/web/img/logo_square_share.jpg'
		]);
		\Yii::$app->view->registerMetaTag([
			'property' => 'og:url',
			'content' => 'justbate.com'
		]);

		\Yii::$app->view->registerMetaTag([
			'property' => 'og:title',
			'content' => 'Justbate, Cause your opinion counts'
		]);
		\Yii::$app->view->registerMetaTag([
			'property' => 'og:description',
			'content' => 'Building healthier debating community together'
		]);

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

	public function actionAddIssue(){
            $add_issue_form = new UserFollowIssueForm();

            if($add_issue_form->load(Yii::$app->request->post()) && $add_issue_form->validate()) {
                if ($add_issue_form->followIssue()) {
                    $issue_list = UserFollowedIssue::getFollowedIssue($add_issue_form->user_id);
                    return $this->renderPartial('home-sidenav-issue', ['issue_list' => $issue_list, 'add_issue_form' => new UserFollowIssueForm()]);
                } else {
                    Yii::$app->end("Cannot follow issue");
                }
            }

            $issue_list = UserFollowedIssue::getFollowedIssue($add_issue_form->user_id);
            return $this->renderPartial('home-sidenav-issue', ['issue_list' => $issue_list , 'add_issue_form' => $add_issue_form]);

	}


	public function actionFollowIssue(){
            if(isset($_POST['issue_name']) && isset($_POST['user_id']) && isset($_POST['command'])){
                $command = $_POST['command'];
                $user_follow_issue_form = new UserFollowIssueForm();
                $user_follow_issue_form->issue_name = $_POST['issue_name'];
                $user_follow_issue_form->user_id = $_POST['user_id'];
                if($command == 'follow_issue'){
                    $success = $user_follow_issue_form->followIssue();
                }
                else{
                    $success = $user_follow_issue_form->unfollowIssue();
                }
                if($success == true){
                    $user_is_follower = UserFollowedIssue::isFollower($user_follow_issue_form->user_id, $user_follow_issue_form->issue_name);
                    $issue_num_followers = UserFollowedIssue::getTotalFollowedIssue($user_follow_issue_form->issue_name);
                    return $this->renderPartial('home-issue-header',
                                                                            ['issue_name' => $user_follow_issue_form->issue_name,
                                                                             'issue_num_followers' => $issue_num_followers,
                                                                             'user_is_follower' => $user_is_follower]
                                                                            );
                }
                else{
                    if($user_follow_issue_form->hasErrors()){
                            Yii::$app->end($user_follow_issue_form->getErrors());
                    }
                }
            }
            else{

            }

            return null;
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
            $signup_model = new SignupForm();
            $login_model = new LoginForm();
            
            return $this->render('login', [
                'login_model' => $login_model,
                'signup_model' => $signup_model, 'modal' => true
            ]);
	}
        
        /**
         * 
         */
        public function actionProcessLogin() {
            
            if(!isset($_POST['modal'])) {
                return;
            }
            $login_model = new LoginForm();
            $modal = $_POST['modal'];
            if ($login_model->load(Yii::$app->request->post()) && $login_model->validate()) {
                if($login_model->login()) {
                    return $this->redirect(Yii::$app->request->baseUrl . '/');
                }
            }
            
            return $this->renderPartial('login-login', ['login_model' => $login_model, 'modal' => $modal]);
            
        }
        

	/**
	 *
	 */
	public function actionGetComment(){

            if(!(Yii::$app->request->isPjax && isset($_GET['thread_id']))) {
                Yii::$app->end("Failed to store votes: " . Yii::$app->request->isPjax . '&' . isset($_GET['thread_id']) );
            }

            $thread_entity = new ThreadEntity($_GET['thread_id'], Yii::$app->user->getId() );
            $creator = (new CreatorFactory())->getCreator(CreatorFactory::THREAD_CREATOR, $thread_entity);
            $thread_entity = $creator->get([ThreadCreator::NEED_THREAD_CHOICE,
                                            ThreadCreator::NEED_THREAD_COMMENTS,
                                            ThreadCreator::NEED_TOTAL_COMMENTS
                                            ]);

            return $this->renderPartial('_list_thread_thread_comment', ['thread' => $thread_entity,'comment_retrieved' => true]);

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
                    return $this->redirect(LinkConstructor::threadLinkConstructor($thread_id, $create_thread_form->title));
                }
            }
            return $this->renderAjax('home-create-thread', ['create_thread_form' => $create_thread_form]);
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

	/**
	 * @return string
	 */
	public function actionEditInterest(){
		return $this->render('edit-interest');
	}

	/**
	 * @param null $q
	 */
	public function actionSearchInNotif($q = null){
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$out = ['results' => ['id' => '', 'text' => '']];
		$data = Thread::getThreadBySearch($q);
		$out['results'] = array_values($data);
		echo Json::encode($out);
	}

        
        public function actionEditUserIssue() {
            if(Yii::$app->user->isGuest) {
                return 0;
            }
            
            if(!isset($_POST['selected_issue'])) {
                return 0;
            }
            $edit_user_issue_form = new EditUserIssueForm();
            $edit_user_issue_form->issue_list = json_decode($_POST['selected_issue']);
            $edit_user_issue_form->user_id = Yii::$app->user->getId();
            if($edit_user_issue_form->validate()) {
                if($edit_user_issue_form->update()) {
                    return 1;
                }
            }

            if($edit_user_issue_form->hasErrors()) {
                \Yii::$app->end(var_dump($edit_user_issue_form->errors));
            }   
            return 0;
            
        }
	/**
         * Json response
	 * @param null $q
	 */
	public function actionSearchIssue(){
            $q = isset($_GET['query']) ? $_GET['query'] : '';
            
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $out = ['results' => ['id' => '', 'text' => '']];
            
            if(isset($_GET['limit']) && is_numeric($_GET['limit'])) {
                $limit = (int) $_GET['limit'];
                $data = Issue::getIssueBySearch($q, isset($_GET['except-own']), Yii::$app->user->getId(), $limit);

            }
            else {
                $data = Issue::getIssueBySearch($q, isset($_GET['except-own']), Yii::$app->user->getId());
            }
            $out['results'] = array_values($data);

            echo Json::encode($out);
	}

	/**
	 * JSON response
	 */
	public function actionSearchAllIssues($q  = null) {
            if(Yii::$app->user->isGuest) {
                    return Json::encode("Not authorized");
            }
            $service = $this->serviceFactory->getService(ServiceFactory::SITE_SERVICE);
            $results = $service->getAllIssues(Yii::$app->user->getId(), $q);
            echo Json::encode($results);
	}

	/**
	 * Signs user up.
	 *
	 * @return mixed
	 */
	public function actionProcessSignup()
	{
            if(!isset($_POST['modal'])) {
                return;
            }
            $model = new SignupForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($user = $model->signup()) {
                    if (Yii::$app->getUser()->login($user)) {
                        return $this->redirect(Yii::$app->request->baseUrl . '/');
                    }
                }
            }
            return $this->render('login-email-register', [
                    'signup_model' => $model,
                    'modal' => $_POST['modal'],
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

	public function actionDeleteFollowList(){
            if(isset($_POST['deleted_issue'])){

                $user_follow_issue_form = new UserFollowIssueForm();

                $user_follow_issue_form->issue_name = $_POST['deleted_issue'];
                $user_follow_issue_form->user_id = Yii::$app->user->getId();

                $success = $user_follow_issue_form->unfollowIssue();

                echo $success;
            }
	}


	
}
