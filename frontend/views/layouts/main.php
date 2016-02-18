<?php

/* @var $this \yii\web\View */
/* @var $content string */
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use common\models\User;
use yii\widgets\Pjax;
use yii\widgets\ListView;


//all links
if(Yii::$app->user->isGuest){
    //all links
    $register_link = Yii::getAlias('@base-url') . '/site/register';
    $login_link = Yii::getAlias('@base-url') . '/site/link';
}
else{
    $logout_link = Yii::getAlias('@base-url') . '/site/logout';
    $profile_link = Yii::getAlias('@base-url') . '/profile/index?username=' . User::getUsername(Yii::$app->getUser()->id);
}


$this->registerCssFile(Yii::$app->request->baseUrl . '/css/style.css');
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/bootstrap-social.css');
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/jquery.js');
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/script.js');

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
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
    <?php $this->beginBody() ?>
    <!-- website menu bar and navigation -->
    <nav class="navbar navbar-default" id="menubar">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= Yii::getAlias('@base-url')?>">Opinion.com</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <form action="" method="GET" class="navbar-form navbar-left" role="search" style="width: auto;">
                        <div class="form-group pull-right" style="display: inline;">
                            <div class="input-group navbar-searchbox" style="display:table;">
                                <input id="search" type="text" placeholder="Search something" class="form-control" />
                                <span style="border: 1px solid black;" class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
                            </div>
                        </div>
                    </form>
                    <?php if(Yii::$app->user->isGuest){ ?>
                        <li class="item"><a id="loginMenu">Login</a></li>
                        <li id="register" class="item"><a href="#">Register</a></li>
                    <?php }else{ ?>
                        <li id="settings" class="item"><a href="<?= Yii::getAlias('@base-url'). '/site/home'?>">Home</a></li>

                        <li id="profile-page" class="item"><a href="<?= $profile_link ?>"><?= User::getUsername(Yii::$app->getUser()->id) ?></a></li>
                        <li class="item dropdown">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle"><span class="glyphicon glyphicon-chevron-down"></span></a>
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

    <?php Modal::begin([
        'id' => 'loginModal'
    ]);
    $redirect_from = $_SERVER['REQUEST_URI'];
    $login_form = new \common\models\LoginForm();

    echo $this->render('../site/login', ['login_form' => $login_form, 'redirect_from' => $redirect_from]);

    Modal::end(); ?>

    <div class="container">
        <?= Breadcrumbs::widget(    [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
    </div>
    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; App Kita <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>
<?php
    $this->registerJsFile(Yii::$app->request->baseUrl.'/js/main.js');
    $this->endBody();
?>
</html>
<?php $this->endPage() ?>
