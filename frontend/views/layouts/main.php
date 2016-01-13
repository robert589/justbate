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

use frontend\models\Thread;
use yii\helpers\ArrayHelper;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl . '../../',
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['../../']],
        ['label' => 'Dashboard', 'url' => ['../../dashboard/create']],
        ['label' => 'Profile', 'url' => ['../../profile/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['../../site/login']];
    } else {
        $menuItems[] = [
            'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }

    $menuItemsLeft = [
        [
            'label' => 'Category',
            'items' => [
                ['label' => 'Critique', 'url' => '#'],
                '<li class="divider"></li>',
                ['label' => 'Solution', 'url' => '#'],
                '<li class="divider"></li>',
                ['label' => 'Proposal', 'url' => '#']
            ]
        ]


    ];


    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $menuItemsLeft,
    ]);

    //Not good practice putting it here
    $data = Thread::retrieveAll();
    $topicData = ArrayHelper::map($data, 'thread_id', 'title');



    echo "<form class='navbar-form navbar-left' role='search'>
       <div class='form-group has-feedback'>".
                Select2::widget([
                    'name' => 'searchThread',
                    'id' => 'searchThread',
                    'value' => '',    
                    'size' => Select2::SMALL,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'width' => '250%'

                        ],
                    'data' => $topicData, // put the data here
                    'options' => ['multiple' => false, 'placeholder' => 'Select threads ...',
                        'class' => 'navbar-form navbar-left form-control'
                    ],
                    'pluginEvents' =>[
                        'select2:select' => "function(){
                                                    var data = $('#searchThread option:selected').val();
                                                    window.location = '" .  Yii::$app->homeUrl  .  "../../thread/index?id=' + data; 
                                            }"
                    ]
                ]). 
                "  </div>
    </form>";
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; App Kita <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
