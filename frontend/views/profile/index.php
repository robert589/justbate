<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use common\models\User;
use frontend\models\UploadForm;
use yii\widgets\ListView;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use kartik\sidenav\SideNav;
use yii\helpers\Url;


?>

<div class="col-md-12">
    <div class="col-md-offset-1 col-md-3" style="margin: 3px">
        <?= SideNav::widget([
            'type' => SideNav::TYPE_DEFAULT,
            'heading' => 'Profile',
            'items' => [
                [
                    'url' => '#',
                    'label' => 'Home',
                    'icon' => 'home'
                ],
                [
                    'label' => 'Help',
                    'icon' => 'question-sign',
                ],
                [
                    'label' => 'About', 
                    'icon'=>'info-sign', 
                    'url'=>'#'
                ],
                [
                    'label' => 'Contact', 
                    'icon'=>'phone', 
                    'url'=>'#'
                ],
            ],
        ]);
        ?>
    
    </div>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <button>Submit</button>

    <?php ActiveForm::end() ?>
    
    




    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="../js/script.js"></script>

    
</body>
