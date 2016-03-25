<?php

use yii\widgets\ActiveForm;

/** @var $create_issue_form \backend\models\CreateIssueForm */
?>

<?php $form = ActiveForm::begin(['action' => ['issue/create'], 'method' => 'post']) ?>

    <?= $form->field($create_issue_form, 'issue_name')->textInput() ?>

    <?= $form->field($create_issue_form, 'issue_description')->textarea(['rows' => 3]) ?>

    <?= \yii\helpers\Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>


<?php ActiveForm::end() ?>
