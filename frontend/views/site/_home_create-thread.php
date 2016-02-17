<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use kartik\widgets\Select2;
    use yii\db\Expression;
    use yii\web\JsExpression;
?>

<div align="center"> <h3>Create Post</h3></div>


<?php $form = ActiveForm::begin(['action' => 'create-thread' ,'method' => 'post']) ?>
<div class="col-xs-8" style="padding: 0;">
    <?= $form->field($create_thread_form, 'title')->textInput(['placeholder' => 'Post Title',
        'class' => 'form-control',
        'style' => "text-align: center;" ])->label(false) ?>
</div>
<div class="col-xs-3" style="padding-right: 0;">
    <?= $form->field($create_thread_form, 'user_choice')->widget(Select2::className(), [
        'data' => $user_choice,
        'options' => ['placeholder' => 'option ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label(false); ?>

</div>
<div class="col-xs-1">
    <?= Html::submitButton("<span class='glyphicon glyphicon-pencil'></span>", ['class' => 'btn btn-default']) ?>

</div>
<?= $form->field($create_thread_form, 'description')->textarea(['placeholder' => 'What are you thinking about it?', 'class' => 'form-control', 'style' => ' height: 175px; width: 100%;'])->label(false) ?>
<div class="col-xs-5">
    <!-- Topic Name -->
    <?= $form->field($create_thread_form, 'category')->widget(Select2::classname(), [
        'initValueText' => $create_thread_form->category,
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
    ])->label(false) ?>
</div>
<div style="vertical-align: middle;" class="col-xs-3">
    <?= $form->field($create_thread_form, 'anonymous')->checkbox([]) ?>
</div>
<div style="vertical-align: middle;" class="col-xs-4"><div style="text-align: center; float: right;">
        <button type="submit" id="create-button" class="btn btn-primary">
            <span id="create-button-label">CREATE</span>
        </button>
    </div>
</div>
<?php ActiveForm::end() ?>
