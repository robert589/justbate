<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$parent_id = $editCommentModel['parent_id'];
//offset

?>
<div class="container">
    <h1><?= Html::encode('Edit Comment') ?></h1>

    <p>Edit Comment</p>

    <div class="row">
        <div class="col-lg-5">
           
        <?php $form =ActiveForm::begin(['id' => "edit-comment-$parent_id"]) ?>


            <div class="row">
                    <?= $form->field($editCommentModel, 'comment')->textArea(['id' => "edit-comment-box-$parent_id", 'placeholder' => 'add comment box...', 'rows' => 4 ]) ?>
              
                    <?= $form->field($editCommentModel, 'parent_id')->hiddenInput()->label(false) ?>

            </div>

            Press  Enter

        <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>



<?php  
$script =<<< JS

$( document ).on('keydown', '#edit-comment-box-$parent_id', function(event){
    if (event.keyCode == 13) {
       
        $("#edit-comment-$parent_id").submit();
        return false;
     }
})
.on('focus', '#child-comment-box-$parent_id', function(){
    if(this.value == "Write your comment here..."){
         this.value = "";
    }
})
.on('blur', '#child-comment-box-$parent_id', function(){
    if(this.value==""){
         this.value = "Write your comment here...";
    }
})
;
JS;
$this->registerJs($script);
?>