<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\Select2;
use yii\db\Expression;
use yii\web\JsExpression;

/** @var $create_thread_form \frontend\models\CreateThreadForm  */
?>

<p>Programmer: This is bad practice, since we have two forms in frontend and backend, code smelly</p>

<?php $form = ActiveForm::begin(['action' => 'create' ,'method' => 'post']) ?>
<!-- Title input box -->
<div style="margin-left: 15px; margin-right: 15px; padding: 15px;">
    <div class="col-xs-12" style="padding: 0;">
        <?= $form->field($create_thread_form, 'title')->textInput(['placeholder' => 'Post Title',
            'class' => 'form-control',
            'style' => "text-align: center;" ])->label(false) ?>
    </div> <!--- div.col-xs-12 -->

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
                'maximumInputLength' => 8,
                'minimumInputLength' => 2,
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
                'maximumInputLength' => 10,
                'minimumInputLength' => 1,
                'allowClear' => true,
                'ajax' => [
                    'url' => \yii\helpers\Url::to(['issue-list']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(topic_name) { return topic_name.text; }'),
                'templateSelection' => new JsExpression('function (topic_name) { return topic_name.text; }'),
            ],
        ])->label(false) ?>
    </div> <!-- div.col-xs-12 -->

    <div style="vertical-align: middle;" class="col-xs-6">
        <?= $form->field($create_thread_form, 'anonymous')->checkbox([]) ?>
    </div> <!-- div.col-xs-6 -->

    <!-- Create Button -->
    <div id="submit-thread" class="col-xs-6">
        <button type="submit" id="create-button" class="btn btn-primary">
            <span id="create-button-label">CREATE</span>
        </button>
    </div> <!-- div.col-xs-6 -->

</div>

<?php ActiveForm::end() ?>
