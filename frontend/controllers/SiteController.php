<?php
namespace frontend\controllers;

use frontend\models\CreateThreadForm;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use common\models\Thread;
use common\models\ThreadTopic;

use frontend\models\ContactForm;
use frontend\models\FilterHomeForm;

use yii\base\InvalidParamException;
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
        ];
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
    * Generate Home page include Trending Tag, Trending Topic, and newest Topic
    */
    public function actionHome(){


        //initial data without filter
        $sql = Thread::retrieveAllBySql();
        $totalCount = Thread::countAll();

        //Topic Newest
        if(!empty($_GET['topic'])){
            $sql = Thread::retrieveSqlByTopic($_GET['topic']);
            $totalCount = Thread::countByTopic($_GET['topic']);
        }

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,  
            'totalCount' => $totalCount,
            'pagination' => [
                'pageSize' =>10,
            ],

        ]);

        //Create form
        $create_thread_form  = new CreateThreadForm();
        $user_choice = $this->getDefaultChoice();

        //retrieve trending topic
        $trending_topic_list = $this->getTredingTopicList();

        //get popular category
        $category_list = $this->getPopularCategory();

        return $this->render('home', ['category_list' => $category_list,
                                    'trending_topic_list' => $trending_topic_list,
                                    'listDataProvider' => $dataProvider,
                                    'user_choice' => $user_choice,
                                    'create_thread_form' => $create_thread_form]);
    }


    public function actionFilteredpjax(){
        Yii::trace("Filtered Pjax Cntroller");
         $sql = Thread::retrieveAllBySql();
        $totalCount = Thread::countAll();


        if(!empty($_POST['filterwords'])){
            $filterArrays = array();

            array_push($filterArrays, $_POST['filterwords']);

            $sql = Thread::retrieveFilterBySql($filterArrays);
            $totalCount = Thread::countFilter($filterArrays);

        }

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,  
            'totalCount' => $totalCount,
          
            'pagination' => [
                'pageSize' =>5,
            ],

        ]);

        return $this->render('home', ['listDataProvider' => $dataProvider]);
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
            if(!empty($_POST['redirectFrom'])){
               $redirectFrom = $_POST['redirectFrom'];
               return $this->redirect($redirectFrom);
            }
            else{
                return $this->goHome(); 
            }
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
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


    public function actionCreateThread(){
        $create_thread_form = new CreateThreadForm();
        $user_choice = $this->getDefaultChoice();
        $create_thread_form->user_id = Yii::$app->user->getId();
        if($create_thread_form->load(Yii::$app->request->post()) && $create_thread_form->validate()){

            if($create_thread_form->create()){
                return $this->redirect(Yii::getAlias('@base-url') . '/site/home');
            }
        }
        else{
            Yii::$app->end(print_r($create_thread_form->getErrors()));
        }

        return $this->renderAjax('home', ['create_thread_form' => $create_thread_form, 'user_choice' => $user_choice]);
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
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
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


    public function actionTopicList(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!empty($_GET['q'])) {
            $q = $_GET['q'];
            $topicList = \common\models\ThreadTopic::getTopicList($q);
            $out['results'] = array_values($topicList);
        }

        return $out;
    }

    private function getDefaultChoice(){
        $defaultChoice = array();
        $defaultChoice['Agree'] = 'Agree';
        $defaultChoice['Disagree'] = 'Disagree';
        $defaultChoice['Neutral'] = 'Neutral';

        return $defaultChoice;
    }

    private function getTredingTopicList(){
        $trending_topic_list = Thread::getTop10TrendingTopic();

        $mapped_trending_topic_list = array();

        foreach($trending_topic_list as $trending_topic){
            $mapped_trending_topic['label'] = $trending_topic['title'];
            $mapped_trending_topic['url'] = Yii::getAlias('@base-url') . '/thread/index?id=' . $trending_topic['thread_id'];

            $mapped_trending_topic_list[] = $mapped_trending_topic;

        }
        return $mapped_trending_topic_list;
    }

    private function getPopularCategory(){
        $category_list = ThreadTopic::getPopularCategory();

        $mapped_category_list = array();
        foreach($category_list as $category){
            $mapped_category['label'] = $category['topic_name'];
            $mapped_category['url']  = Yii::getAlias('@base-url') . '/site/home?category=' . $category['topic_name'];

            $mapped_category_list[] = $mapped_category;
        }


        return $mapped_category_list;
    }
}
