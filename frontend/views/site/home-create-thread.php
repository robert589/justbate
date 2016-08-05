<?php
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use common\components\Constant;
/** @var $create_thread_form \frontend\models\CreateThreadForm */
?>

<?php Pjax::begin() ?>
    <?php $form = ActiveForm::begin(['action' => ['site/create-thread'] ,
        'method' => 'post', 'id' => 'form-action',
         'enableClientValidation' => true, 'validateOnBlur' => false, 'validateOnSubmit' => true]) ?>

    <div id="create-thread-wrapper">
        <div class="col-xs-12" id="create-thread">
            <div class="col-xs-12" id="create-thread-dropdown">
                <div id="create-thread-button">
                    <div class="input-group">
                        <?= $form->field($create_thread_form,
                                        'title')
                                 ->textInput(['class' => 'form-control', 'id' => 'create-thread-title', 'placeholder' => "Write any topic to discuss here.."]) ?>
                    </div>
                </div>
            </div> <!-- div.col-xs-12 -->
        </div>

        <div class="col-xs-12" id="create-thread-main-form">
            <div class="col-xs-12" style="padding: 0;margin-top:8px">
                <?= $form->field($create_thread_form, 'description')->widget(\yii\redactor\widgets\Redactor::className(),
                [   
                    'clientOptions' => [
                        'placeholder' => 'Description here.. ',
                        'buttons' => Constant::defaultButtonRedactorConfig(),
                        'plugins' => Constant::defaultPluginRedactorConfig(),
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
            </div> 
            <div class="col-xs-12" style="padding:0;margin-top:5px">
                <!-- Topic Name -->
                <?= $form->field($create_thread_form, 'issues')->widget(Select2::classname(), [
                    'initValueText' => $create_thread_form->issues,
                    'maintainOrder' => true,
                    'options' => ['placeholder' => 'Select Keywords ...', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => true,
                        'ajax' => [
                            'url' => \yii\helpers\Url::to(['search-issue']),
                            'dataType' => 'json',
                               'data' => new JsExpression('function(params) { return {query:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(topic_name) { return topic_name.text; }'),
                        'templateSelection' => new JsExpression('function (topic_name) { return topic_name.text; }'),
                    ],
                    ])->label(false) ?>
            </div> 
            <div class="col-xs-12" style="margin-top:5px">
                <div class="col-xs-6">
                    <?= $form->field($create_thread_form, 'anonymous')->checkbox([]) ?>
                </div> <!-- div.col-xs-6 -->

                <!-- Create Button -->
                <div id="submit-thread" class="col-xs-6">
                    <button align="right" style="float:right" type="submit" id="create-button" class="btn btn-primary">
                        <span id="create-button-label">Create</span>
                    </button>
                </div>
            </div> 
        </div>
    </div>

    <?php ActiveForm::end() ?>
<?php Pjax::end() ?>