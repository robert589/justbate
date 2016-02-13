<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ListView;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use common\models\User;

/*
if($user['id'] == \Yii::$app->user->identity->getId() ){
    $belongs = 1;
}
else{
    $belongs = 0;
}
*/
//Set title for the page
$this->title = $user->first_name . ' ' . $user->last_name;
?>
<!-- Edit Profile Modal-->
<?php
    Modal::begin([
        'id' => 'editModal',
        'size' => 'modal-lg'
    ]);

    $editProfileModel = new \frontend\models\EditProfileForm();
    $editUser = new User();
  //  $editUser->id = \Yii::$app->user->identity->getId();
    $user_data = $editUser->getUser();

    //pass data
    $editProfileModel->occupation = $user_data['occupation'];
    $editProfileModel->birthday = $user_data['birthday'];
    $editProfileModel->first_name = $user_data['first_name'];
    $editProfileModel->last_name = $user_data['last_name'];
    echo $this->render('edit', ['model' => $editProfileModel]);

    Modal::end();
?>


<!-- Upload photo modal -->
<?php
    Modal::begin([
        'id' => 'uploadProfilePicModal',
        'size' => 'modal-lg'
    ]);

    $uploadFormModel = new \frontend\models\UploadProfilePicForm();

    echo $this->render('_upload_photo_modal', ['model' => $uploadFormModel]);


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
                    <a href="#">All tags</a>
                </li>

            </ul>
        </div>


        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-3">
                            <img src="<?= Yii::getAlias('@image_dir') . '/' . $user->photo_path ?>" alt="Profile Picture" style="width:180px;height:180px;">
                            <?= Html::button('Upload Photo', ['onclick' => 'beginProfilePicModal()', 'class' => 'btn btn-primary']) ?>
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

                        </div>
                        <div class="col-lg-3">


                        </div>

                    </div>
                </div>
<div class="col-md-12">


<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/js/profile-index.js'); ?>




    
