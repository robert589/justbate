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
           
        <?php $form =ActiveForm::begin(['id' => "edit-comment-<?= $parent_id ?>"]) ?>


            <div class="row">
                    <?= $form->field($editCommentModel, 'comment')->textArea(['id' => 'comment-box', 'placeholder' => 'add comment box...', 'rows' => 4 ]) ?>
              

            </div>

        <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>