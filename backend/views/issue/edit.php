<?php

use yii\widgets\ActiveForm;

/** @var $edit_issue_form \backend\models\EditIssueForm */
/** @var $issue array */
?>

<?php $form = ActiveForm::begin(['action' => ['issue/edit?id=' . $issue['issue_id']], 'method' => 'post']) ?>

<?= $form->field($edit_issue_form, 'issue_name')->textInput(['value' => $issue['issue_name']]) ?>

<?= $form->field($edit_issue_form, 'issue_description')->textarea(['rows' => 3, 'value' => $issue['issue_description']]) ?>

<?= \yii\helpers\Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>


<?php ActiveForm::end() ?>
