<?php
use kartik\widgets\ActiveForm;
/** @var $user /common/models/User */
/** @var $promote_form \backend\models\PromoteForm */
/** @var $auth_item array */
/** @var $auth_assignment array */

?>

<div class="container-fluid">
    <div class="col-md-12">
        <h1> User:   <?= $user->first_name . ' '  . $user->last_name ?>
        </h1>
    </div>
    <div class="col-md-6">
        <?php $form = ActiveForm::begin(['action' => 'promote?id=' . $user->id, 'method' => 'post']) ?>
            <?= $form->field($promote_form, 'roles')->multiselect($auth_item) ?>

            <?= \yii\helpers\Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end() ?>
    </div>
    <div class="col-md-6">
        <label>Current Assignment</label>
        <?php foreach($auth_assignment as $assignment){ ?>
            <div class="row">
                <?= $assignment->item_name ?>
            </div>
        <?php } ?>
    </div>
</div>

