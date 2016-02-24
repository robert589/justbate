<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use kartik\widgets\Select2;
    use yii\db\Expression;
    use yii\web\JsExpression;
    use dosamigos\ckeditor\CKEditor;
?>

<div align="center"> <h3>Create Post</h3></div>


<?php $form = ActiveForm::begin(['action' => 'create-thread' ,'method' => 'post']) ?>
    <!-- Title input box -->
    <div class="col-xs-12" style="padding: 0;">
        <?= $form->field($create_thread_form, 'title')->textInput(['placeholder' => 'Post Title',
            'class' => 'form-control',
            'style' => "text-align: center;" ])->label(false) ?>
    </div>

    <div class="col-xs-12" style="padding: 0;">

        <?= $form->field($create_thread_form, 'description')->widget(\yii\redactor\widgets\Redactor::className(),
            [
                'clientOptions' => [
                    'imageUpload' => \yii\helpers\Url::to(['/redactor/upload/image']),
                ],

            ]) ?>
    </div>

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
    </div>

    <div class="col-xs-12" style="padding:0;">
        <!-- Topic Name -->
        <?= $form->field($create_thread_form, 'keywords')->widget(Select2::classname(), [
            'initValueText' => $create_thread_form->keywords,
            'maintainOrder' => true,

            'options' => ['placeholder' => 'Select Keywords ...', 'multiple' => true],
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 10,
                'minimumInputLength' => 1,
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
        ])->label(false) ?>
    </div>
    <!--Anonymous-->
    <div style="vertical-align: middle;" class="col-xs-6">
        <?= $form->field($create_thread_form, 'anonymous')->checkbox([]) ?>
    </div>

    <!-- Create Button -->
    <div style="vertical-align: middle;" class="col-xs-6"><div style="text-align: center; float: right;">
            <button type="submit" id="create-button" class="btn btn-primary">
                <span id="create-button-label">CREATE</span>
            </button>
        </div>
    </div>
<?php ActiveForm::end() ?>
