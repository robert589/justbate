<?php

/* @var $this \yii\web\View */
/* @var $content string */
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\Thread;
use yii\helpers\ArrayHelper;
use common\models\User;
use yii\widgets\Pjax;
use yii\widgets\ListView;


$home_link = Yii::getAlias('@base-url') . '/site/home';


//all links
if(Yii::$app->user->isGuest){
    //all links
    $register_link = Yii::getAlias('@base-url') . '/site/register';
    $login_link = Yii::getAlias('@base-url') . '/site/link';
}
else{
    $logout_link = Yii::getAlias('@base-url') . '/site/logout';
    $profile_link = Yii::getAlias('@base-url') . '/profile/index.php?username=' . User::getUsername(Yii::$app->getUser()->id);
}


$this->registerCssFile(Yii::$app->request->baseUrl . '/css/bootstrap-social.css');
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/style.css');
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/superhero-bootstrap.min.css');
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/bootstrap-social.css');
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/script.js');
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.js');

AppAsset::register($this);
?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<!--Head Part-->
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <!-- website menu bar and navigation -->
    <nav class="navbar navbar-default" id="menubar">
        <div class="container-fluid" style="color: white !important;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Website Name</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-left">
                    <li class="item" id="active"><a href="#">Homepage</a></li>
                    <li class="item"><a href="#">Main Lobby</a></li>
                    <li class="item"><a href="#">About Us</a></li>
                    <li class="item"><a href="#">Help</a></li>
                    <li class="divider"></li>
                    <!-- <li class="item dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">Messages<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                    <li><a href="#">Inbox</a></li>
                    <li><a href="#">Drafts</a></li>
                    <li><a href="#">Sent Items</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Trash</a></li> -->
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li id="search" class="item">
                        <form action="" method="GET">
                            <span class="input-group">
                                <input style="background: #AA3939; border: 1px solid white; color: white;" type="text" placeholder="Search something" class="form-control" />
                            </span>
                        </form>
                    </li>
                     <?php if(Yii::$app->user->isGuest){ ?>
                        <li style="border-left: 1px solid rgba(18,18,18,.25);" id="login" class="item" data-toggle="modal" data-target="#login-box"><a>Login</a></li>
                        <li id="register" class="item"><a href="<?= $register_link?>">Register</a></li>
                    <?php }else{ ?>
                         <li id="profile-page" class="item"><a href="<?= $profile_link ?>"> <?= User::getUsername(Yii::$app->getUser()->id) ?> </a></li>
                         <li id="settings" class="item"><a href="#">Settings</a></li>
                         <li id="logout" class="item"><a  data-method="post" href="<?= $logout_link ?>">Logout</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<!-- modal for login box -->
<div id="login-box" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div style="text-align: center;">LOGIN FORM
                    <span data-dismiss="modal" data-target="#login-box" style="float: right; cursor: pointer;">&times;</span>
                </div>
            </div>
            <div class="modal-body">
                <table class="table table-responsive table-bordered" align="center" id="login-form">
                    <tr><td><input id="username" type="text" placeholder="Your Username" /></td></tr>
                    <tr><td><input id="password" type="password" placeholder="Your Password" /></td></tr>
                </table>
                <button id="sign-up" class="btn btn-primary">Sign Up</button><hr />
                <div class="row">
                    <div id="social-icon">
                        <div class="col-xs-4"><a class="btn btn-md btn-block btn-social btn-twitter" id="socmed-login"><span class="fa fa-twitter"></span> Sign in with Twitter</a></div>
                        <div class="col-xs-4"><a class="btn btn-md btn-block btn-social btn-facebook" id="socmed-login"><span class="fa fa-facebook"></span> Sign in with Facebook</a></div>
                        <div class="col-xs-4"><a class="btn btn-md btn-block btn-social btn-google" id="socmed-login"><span class="fa fa-google"></span> Sign in with Google</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; App Kita <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
<?php
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/main.js');
$this->endBody(); ?>
</body>
</html>
<?php $this->endPage() ?>
