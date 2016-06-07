<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use kartik\sidenav\SideNav;

AppAsset::register($this);

$this->registerJsFile(Yii::$app->request->baseUrl . '/../backend/web/js/jquery.js');
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
        'brandLabel' => 'Opilage',
        'brandUrl' => Yii::$app->request->baseUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>


    <?php

    $items = [
        ['label' => 'Threads',
            'items' =>[
                ['label' => 'All Thread', 'url' => Yii::$app->request->baseUrl . '/site/thread'],
                ['label' => 'Create Thread', 'url' => Yii::$app->request->baseUrl . '/thread/create'],

            ]
        ],
        ['label' => 'Comments',
            'icon'=> 'comment',
            'items' =>[
                ['label' => 'Thread Comment', 'url' => Yii::$app->request->baseUrl . '/site/thread-comment'],
                ['label' => 'Child Comment', 'url' => Yii::$app->request->baseUrl . '/site/child-comment']

            ]
        ],

        ['label' => 'Issue',
            'items' =>[
                ['label' => 'All Issues', 'url' => Yii::$app->request->baseUrl . '/issue/list'],
                ['label' => 'Create Issues', 'url' => Yii::$app->request->baseUrl . '/issue/create'],
                ['label' => 'Request Issues', 'url' => Yii::$app->request->baseUrl . '/issue/request'],

            ]
        ],
        ['label' => 'Users',
            'items' => [
                ['label' => 'Registered Users', 'url' => Yii::$app->request->baseUrl . '/site/user']
            ]
        ],
        ['label' => 'Access Control',
         'url' => Yii::$app->request->baseUrl . '/admin'
        ]
    ];
    ?>

    <div class="container">
        <div class="col-md-2">
            <?=
            SideNav::widget(['items' => $items, 'heading' => false])
            ?>
        </div>
        <div class="col-md-10">

            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
</footer>

<?php $this->endBody();
    $this->registerJsFile(Yii::$app->request->baseUrl . '/../backend/web/js/script.js');
?>
</body>
</html>
<?php $this->endPage() ?>
