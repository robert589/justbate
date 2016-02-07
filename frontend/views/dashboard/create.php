<?php
use dosamigos\ckeditor\CKEditor;
use yii\web\JsExpression;

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Dropdown;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use unclead\widgets\MultipleInput;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.js');
$this->title = "Create Proposal";

?>

<?php $form = ActiveForm::begin(['id' => 'create-thread-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="col-md-12">

    <div class="col-md-9 col-md-offset-2">
        <div class="row">
            <?= $form->field($thread, 'title') ?>

        </div>

        <div class="row">
            <?= $form->field($thread, 'topic_description')->widget(CKEditor::className(), [
                'options' => ['rows' => 10],
                'preset' => 'basic',
                'clientOptions' => [
                    'filebrowserUploadUrl' => 'site/url'
                ]
            ]) ?>
        </div>


        <div class="row">

            <?= $form->field($thread, 'user_opinion')->widget(CKEditor::className(), [
                'options' => ['rows' => 10],
                'preset' => 'basic',
                'clientOptions' => [
                    'filebrowserUploadUrl' => 'site/url'
                ]
            ]) ?>
        </div>

        <hr>
        <!-- cHOICE OPTION -->

        <?= $this->render('_choice_thread', ['form' => $form, 'choices' => $choices]) ?>



        <hr>
        <!-- Relevant parties-->
        <div class="row">

            <?= $form->field($thread, 'relevant_parties')->widget(Select2::classname(), [

                'options' => [
                    'label' => 'Relevant Parties',
                    'placeholder' => 'Select relevant parties ...',
                    'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'ajax' => [
                        'url' => \yii\helpers\Url::to(['user-list']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(relevant_parties) { return relevant_parties.text; }'),
                    'templateSelection' => new JsExpression('function (relevant_parties) { return relevant_parties.text; }'),
                ]

            ]) ?>

        </div>


        <div class="row">
            <!-- Topic Name -->
            <?= $form->field($thread, 'topic_name')->widget(Select2::classname(), [
                'initValueText' => $thread->topic_name,
                'options' => ['placeholder' => 'Select topic name ...'],
                'pluginOptions' => [
                    'minimumInputLength' => 3,
                    'allowClear' => true,
                    'ajax' => [
                        'url' => \yii\helpers\Url::to(['topic-list']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(topic_name) { return topic_name.text; }'),
                    'templateSelection' => new JsExpression('function (topic_name) { return topic_name.text; }'),
                ],
            ]) ?>

        </div>

        <?= $form->field($thread, 'anonymous')->checkbox() ?>

        <div align="center">
            <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>

<br><br>

<?php ActiveForm::end(); ?>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/js/dashboard-create.js' )?>