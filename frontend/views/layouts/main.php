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
use frontend\vo\ChildCommentVoBuilder;
//all links
if(Yii::$app->user->isGuest){
    //all links
    $login_link = Yii::$app->request->baseUrl . '/site/link';
}
else{
    $logout_link = Yii::$app->request->baseUrl . '/site/logout';
    $profile_link = Yii::$app->request->baseUrl . '/user/' . User::getUsername(Yii::$app->getUser()->id);
}
$this->registerCssFile(Yii::$app->request->baseUrl . '/frontend/web/css/style.css');
$this->registerCssFile(Yii::$app->request->baseUrl . '/frontend/web/css/dropdown.css');
$this->registerCssFile(Yii::$app->request->baseUrl . '/frontend/web/css/bootstrap-social.css');
$this->registerJsFile(Yii::$app->request->baseUrl . '/frontend/web/js/jquery.js');
$this->registerJsFile(Yii::$app->request->baseUrl . '/frontend/web/js/jquery-ias.min.js');
$temp_localhost = Html::encode(Yii::$app->request->baseUrl);
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
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?= Yii::$app->request->baseUrl . '/frontend/web/img/logo_square.ico' ?>" />
</head>
<body>
    <?php $this->beginBody() ?>
    <!-- website menu bar and navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" id="menubar">
        <div class="nav-container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="<?= Yii::$app->urlManager->createAbsoluteUrl(['']) ?>">
                    <img src="<?= Yii::$app->request->baseUrl . '/frontend/web/img/logo.png' ?>"
                    style="height:45px;margin-top:-10px;margin-left:15px;width:145px">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav" id="menubar-left">
                    <li id="search-box" class="item">
                        <?= Select2::widget([
                            'name' => 'search_box_menu',
                            'class'  => 'form-input',
                            'id' => 'search_box_menu',
                            'theme' => Select2::THEME_KRAJEE,
                            'options' => ['placeholder' => 'Search'],
                            'pluginEvents' => [
                                "select2:select" => "function(){
                                    window.location.replace(
                                    'http://' +  document.domain  + '$temp_localhost' + '/thread/' + $('#search_box_menu').val() + '/' +
                                    $('#search_box_menu').text().replace(
                                    'Search','').replace(/ /g, '-').toLowerCase()
                                );
                            }"
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'maximumSelectionSize' => 1,
                                'multiple' => true,
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
                        ])?>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right" id="menubar-right">
                    <?php if(Yii::$app->user->isGuest){ ?>
                        <li class="item"><a id="loginMenu">Login</a></li>
                        <?php } else { ?>
                            <li class="user_item item" id="home_menu_bar"><a href="<?=Yii::$app->request->baseUrl. '/site/home'?>">Home</a></li>
                            <li class="user_item dropdown" id="notification-bar"><?= $this->render('../notification/index') ?></li>
                            <li class="user_item item"><a href="<?= $profile_link ?>"><img id="profile-picture-home" src=<?= Yii::getAlias('@image_dir') . '/'. User::findOne(Yii::$app->getUser()->id)->photo_path ?> height="20px;" /><?= User::findOne(Yii::$app->getUser()->id)->first_name ?></a></li>
                            <li class="user_item dropdown item" id="dropdown-menu-settings">
                                <a href="#" style="color: white;" data-toggle="dropdown" class="dropdown-toggle">
                                    <span class="glyphicon glyphicon-chevron-down">
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="item">
                                        <a href="#">Settings</a>
                                    </li>
                                    <li id="logout" class="item">
                                        <a  data-method="post" href="<?= $logout_link ?>">Logout</a>
                                    </li>
                                </ul>
                            </li>
                            <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php
        Modal::begin([
            'id' => 'loginModal',
            'size' => Modal::SIZE_LARGE
        ]);
            $login_form = new \common\models\LoginForm();
            echo $this->render('../site/login', ['login_form' => $login_form, 'model' => new \frontend\models\SignupForm()]);
        Modal::end();
    ?>

    <div class="container" id="home-container" >
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        <div id="loading-bar" style="left: 0; right: 0; display: none; margin-top: -73px; margin-left: -100%; margin-right: -18.65%; height: 100% !important;">
            <div style='z-index:0;left:0;top:0;width:100% !important;height:100% !important;background:#ddd;opacity: 0.4;'>Loading</div>
        </div>
    </div>


    <?= Html::hiddenInput('base_url', Yii::$app->request->baseUrl, ['id' => 'base-url' ]) ?>
    <!-- hidden input -->

    <!-- User stored session -->
    <?= Html::hiddenInput('user_id',
                        (Yii::$app->user->getId() !== null) ? Yii::$app->user->getId() : null,
                        ['id' => 'user-login-id']) ?>
    
    <?php if(!Yii::$app->user->isGuest) { ?>
        
        <?= Html::hiddenInput('username',
                            Yii::$app->user->identity->username ,
                            ['id' => 'user-login-username']) ?>
    
        <?= Html::hiddenInput('first-name',
                            (Yii::$app->user->identity->first_name) ,
                            ['id' => 'user-login-first-name']) ?>

        <?= Html::hiddenInput('first-name',
                        (Yii::$app->user->identity->last_name) ,
                        ['id' => 'user-login-last-name']) ?>
    
        <?= Html::hiddenInput('photo-path', 
                              Yii::$app->user->identity->photo_path,
                            ['id' => 'user-login-photo-path']) ?>
    
    <?php } ?>
    <div style="display: none" id="child-comment-template">
        <div class="item" >
            <?php $builder = new ChildCommentVoBuilder();
            $builder->setCommentCreatorId(Yii::$app->user->getId());
            $builder->convertToTemplate();
            $child_comment_dummy = $builder->build();
            ?>
            <?= $this->render('../comment/child-comment',
            ['child_comment' => $child_comment_dummy]) ?>
        </div>
    </div>

<?php
    $this->registerJsFile(Yii::$app->request->baseUrl . '/frontend/web/js/script.js');
    $this->endBody();
?>
</html>
<?php $this->endPage() ?>
