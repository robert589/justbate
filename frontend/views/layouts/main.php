<?php

/* @var $this \yii\web\View */
/* @var $content string */
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap\Modal;
use common\models\User;
use yii\web\JsExpression;
use kartik\widgets\Typeahead;
use yii\helpers\Url;

//all links
if(Yii::$app->user->isGuest){
    //all links
    $register_link = Yii::$app->request->baseUrl . '/site/signup';
    $login_link = Yii::$app->request->baseUrl . '/site/link';
}
else{
    $logout_link = Yii::$app->request->baseUrl . '/site/logout';
    $profile_link = Yii::$app->request->baseUrl . '/user/' . User::getUsername(Yii::$app->getUser()->id);
}

$this->registerCssFile(Yii::$app->request->baseUrl . '/frontend/web/css/style.css');
$this->registerCssFile(Yii::$app->request->baseUrl . '/frontend/web/css/bootstrap-social.css');
$this->registerJsFile(Yii::$app->request->baseUrl . '/frontend/web/js/jquery.js');

$temp_localhost = Yii::$app->request->baseUrl;
AppAsset::register($this);
?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<!--Head Part-->
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
</head>
<body>
    <?php $this->beginBody() ?>
    <!-- website menu bar and navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" id="menubar">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= Yii::$app->urlManager->createAbsoluteUrl(['']) ?>">JUSTBATE.com</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <li id="search-box" class="item">
                        <?=
                        Select2::widget([
                            'name' => 'search_box_menu',
                            'class'  => 'form-input',
                            'id' => 'search_box_menu',
                            'theme' => Select2::THEME_KRAJEE,
                            'options' => ['placeholder' => 'Search'],
                            'pluginEvents' => [
                                "select2:select" => "function(){
                                    window.location.replace(
                                    'http://' +  document.domain  + '$temp_localhost' + '/thread/index?id=' + $('#search_box_menu').val()  );
                                }"
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 1,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                ],
                                    'ajax' => [
                                    'url' => \yii\helpers\Url::to(['site/search-in-notif']),
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                'templateResult' => new JsExpression('function(thread) { return thread.text; }'),
                                'templateSelection' => new JsExpression('function (thread) { return thread.text; }'),
                            ],
                        ])
                        ?>
                    </li>
                    <?php if(Yii::$app->user->isGuest){ ?>
                        <li class="item"><a id="loginMenu">Login</a></li>
                        <li id="register" class="item"><a href=<?= $register_link ?>>Register</a></li>
                        <?php } else { ?>
                            <li class="item"><a href="<?=Yii::$app->request->baseUrl. '/site/home'?>">Home</a></li>
                            <li class="dropdown" id="notification-bar"><?= $this->render('../notification/index') ?></li>
                            <li class="item"><a href="<?= $profile_link ?>"><img id="profile-picture-home" src="/startUp/frontend/web/photos/<?= User::findOne(Yii::$app->getUser()->id)->photo_path ?>" height="20px;" /><?= User::findOne(Yii::$app->getUser()->id)->first_name ?></a></li>
                            <li class="dropdown" id="dropdown-menu-settings">
                                <a href="#" style="color: white;" data-toggle="dropdown" class="dropdown-toggle"><span class="glyphicon glyphicon-chevron-down"></span></a>
                                <ul class="dropdown-menu">
                                    <li class="item"><a href="#">Settings</a></li>
                                    <li id="logout" class="item"><a  data-method="post" href="<?= $logout_link ?>">Logout</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php
    Modal::begin([
        'id' => 'loginModal'
    ]);
        $redirect_from = $_SERVER['REQUEST_URI'];
        $login_form = new \common\models\LoginForm();
        echo $this->render('../site/login', ['login_form' => $login_form, 'redirect_from' => $redirect_from]);
    Modal::end();
    ?>

    <div class="container" style="position:relative;margin-top: 73px;">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        <div id="loading-bar" style="display: none">
            <div style='position:absolute;z-index:0;left:0;top:0;width:100%;height:100%;background-color:white;opacity: 0.4;'>
                Loading
            </div>
        </div>
    </div>



<?php
    $this->registerJsFile(Yii::$app->request->baseUrl . '/frontend/web/js/script.js');
    $this->endBody();
?>
</html>
<?php $this->endPage() ?>
