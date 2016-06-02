<?php
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\Select2;
use yii\db\Expression;
use yii\web\JsExpression;

/** @var $create_thread_form \frontend\models\CreateThreadForm */
?>

<?php $form = ActiveForm::begin(['action' => ['site/create-thread'] ,'method' => 'post', 'id' => 'form-action']) ?>
<!-- Title input box -->

<div id="create-thread-wrapper">
    <div class="col-xs-12" id="create-thread">
        <div class="col-xs-12" id="create-thread-dropdown">
            <div id="create-thread-button">
                <div class="input-group">
                    <?= $form->field($create_thread_form, 'title',   [ 'addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-pencil"></i>']]]
                                 )->textInput(['class' => 'form-control', 'id' => 'create-thread-title', 'placeholder' => "Topic title"]) ?>
                </div>
            </div>
        </div> <!-- div.col-xs-12 -->
    </div>

    <div class="col-xs-12" id="create-thread-main-form">

        <div class="col-xs-12" style="padding: 0;">
            <?= $form->field($create_thread_form, 'description')->widget(\yii\redactor\widgets\Redactor::className(),
            [
                'clientOptions' => [
                    'imageUpload' => \yii\helpers\Url::to(['/redactor/upload/image']),
                ],
             ]) ?>
        </div> <!-- div.col-xs-12 -->

        <!-- Choice -->
        <div class="col-xs-12" style="padding: 0;">
            <?= $form->field($create_thread_form, 'choices')->widget(Select2::className(), [
                'initValueText' => $create_thread_form->choices,
                'maintainOrder' => true,
                'options' => ['placeholder' => 'Add Choices ...', 'multiple' => true],
                'pluginOptions' => [
                    'tags' => true,
                    'minimumInputLength' => 1,
                ]
            ])->label(false) ?>
        </div> <!-- div.col-xs-12 -->

        <div class="col-xs-12" style="padding:0;">
            <!-- Topic Name -->
            <?= $form->field($create_thread_form, 'issues')->widget(Select2::classname(), [
                'initValueText' => $create_thread_form->issues,
                'maintainOrder' => true,
                'options' => ['placeholder' => 'Select Keywords ...', 'multiple' => true],
                'pluginOptions' => [
                    'minimumInputLength' => 1,
                    'allowClear' => true,
                    'ajax' => [
                        'url' => \yii\helpers\Url::to(['search-issue']),
                        'dataType' => 'json',
                           'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(topic_name) { return topic_name.text; }'),
                    'templateSelection' => new JsExpression('function (topic_name) { return topic_name.text; }'),
                ],
                ])->label(false) ?>
        </div> <!-- div.col-xs-12 -->

        <div class="col-xs-6">
            <?= $form->field($create_thread_form, 'anonymous')->checkbox([]) ?>
        </div> <!-- div.col-xs-6 -->

        <!-- Create Button -->
        <div id="submit-thread" class="col-xs-6">
            <button type="submit" id="create-button" class="btn btn-primary">
                <span id="create-button-label">Create</span>
            </button>
        </div> <!-- div.col-xs-6 -->

    </div>
</div>

<?php ActiveForm::end() ?>
