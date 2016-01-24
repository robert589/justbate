<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ListView;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;


//Set title for the page
$this->title = $user->first_name . ' ' . $user->last_name;
?>

<?php
    Modal::begin([
        'id' => 'editModal',
        'size' => 'modal-lg'
    ]);

    $loginModel = new \frontend\models\EditProfileForm();
    echo $this->render('edit', ['model' => $loginModel]);

    Modal::end();
?>
     <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        Feeds
                    </a>
                </li>
                <li> 
                    <a href="#">All Activity</a>
                </li>

                <li>
                    <a href="#">Followers <span class="badge">5</span></a>
                </li>
                <li>
                    <a href="#">Following <span class="badge">5</span></a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->
        <div id="page-content">

        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-3">
                            <img src="girl.jpg" alt="Profile Picture" style="width:180px;height:180px;">
                        </div>
                        <div class="col-lg-6">
                            <div id="displayName">
                                <?= $user->first_name ?>
                                <?= $user->last_name ?>
                            </div>
                            <div >
                                Birthday: <?= $user->birthday ?>

                            </div>
                            <div >
                                Occupation: <?= $user->occupation ?>

                            </div>
                            <hr>
                            <div >
                                <?php if($user->business == 1){ ?>
                                    <label> Business Side</label>
                                <?php }else{ ?>
                                    <?= Html::a('Upgrade to business', ['profile/business'], ['class' => 'btn btn-primary'])?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <button onclick="beginEditModal()" class="btn btn-default"> <span class="glyphicon glyphicon-pencil	"></span> Edit Profile </button>

                        </div>

                    </div>
                </div>
<div class="col-md-12">


    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

                <br>
                <!-- /#page-content-wrapper -->

                <!-- Recent Activity-->
                <div class="well well-sm">
                    <h4>Recent Activity</h4>
                </div>

                <div>
                    <?= ListView::widget([
                        'dataProvider' => $recent_activity_provider,
                        'options' => [
                            'tag' => 'div',
                            'class' => 'list-wrapper',
                            'id' => 'list-wrapper',
                        ],
                        'layout' => "{summary}\n{items}\n{pager}",

                        'itemView' => function ($model, $key, $index, $widget) {
                            return $this->render('_list_activity',['model' => $model]);
                        },
                        'pager' => [
                            'firstPageLabel' => 'first',
                            'lastPageLabel' => 'last',
                            'nextPageLabel' => 'next',
                            'prevPageLabel' => 'previous',
                            'maxButtonCount' => 3,
                        ],
                    ]) ?>
                </div>

                <br>
                <!-- Recent Tag-->
                <div class="well well-sm">
                    <h4>Recent Tag</h4>
                </div>

                <div>
                    <?= ListView::widget([
                        'dataProvider' => $recent_tags_provider,
                        'options' => [
                            'tag' => 'div',
                            'class' => 'list-wrapper',
                            'id' => 'list-wrapper',
                        ],
                        'layout' => "\n{items}\n{pager}",

                        'itemView' => function ($model, $key, $index, $widget) {
                            return $this->render('_list_tag',['model' => $model]);
                        },
                        'pager' => [
                            'firstPageLabel' => 'first',
                            'lastPageLabel' => 'last',
                            'nextPageLabel' => 'next',
                            'prevPageLabel' => 'previous',
                            'maxButtonCount' => 3,
                        ],
                    ]) ?>
                </div>

        </div>
        </div>
     </div>

</div>
    <?php ActiveForm::end() ?>

<?php	$this->registerJsFile(Yii::$app->request->baseUrl.'/js/profile-edit.js'); ?>




    
