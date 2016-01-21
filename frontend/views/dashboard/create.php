<?php
use dosamigos\ckeditor\CKEditor;
use yii\web\JsExpression;

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Dropdown;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.js');

$this->title = "Create Proposal";
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="col-md-12">

    <div class="col-md-6">
        <?= $form->field($thread, 'title') ?>


        <?= $form->field($thread, 'content')->widget(CKEditor::className(), [
            'options' => ['rows' => 10],
            'preset' => 'basic',
            'clientOptions' => [
                'filebrowserUploadUrl' => 'site/url'
            ]
        ]) ?>

        <?= Select2::widget([
            'id' => 'select2relevant_parties',
            'name' => 'relevant_parties',
            'data' => $businessPeople,
            'options' => [
                'label' => 'Relevant Parties',
                'placeholder' => 'Select relevant parties ...',
                'multiple' => true],
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 6
            ],
            'pluginEvents' => [
                "select2:select" => "function(){
                                        $('#create-thread-relevant_parties').val($('#select2relevant_parties').val());
                                    }"
            ]
        ]) ?>

        <?= $form->field($thread, 'relevant_parties')->hiddenInput(['id' => 'create-thread-relevant_parties'])->label(false) ?>

        <?= $form->field($thread, 'topic_id')->widget(Select2::classname(), [
            'data' => $threadTopics,
            'options' => ['placeholder' => 'Select state ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>

    </div>

    <div class="col-md-6">


        <?= $form->field($thread, 'coordinate')->widget('\pigolab\locationpicker\CoordinatesPicker' , [
            'valueTemplate' => '{latitude},{longitude}' , // Optional , this is default result format
            'options' => [
                'style' => 'width: 100%; height: 400px',  // map canvas width and height
            ] ,
            'enableSearchBox' => true , // Optional , default is true
            'searchBoxOptions' => [ // searchBox html attributes
                'style' => 'width: 300px;', // Optional , default width and height defined in css coordinates-picker.css
            ],
            'searchBoxPosition' => new JsExpression('google.maps.ControlPosition.TOP_LEFT'), // optional , default is TOP_LEFT
            'mapOptions' => [
                // google map options
                // visit https://developers.google.com/maps/documentation/javascript/controls for other options
                'mapTypeControl' => true, // Enable Map Type Control
                'mapTypeControlOptions' => [
                    'style'    => new JsExpression('google.maps.MapTypeControlStyle.HORIZONTAL_BAR'),
                    'position' => new JsExpression('google.maps.ControlPosition.TOP_LEFT'),
                ],
                'streetViewControl' => true, // Enable Street View Control
            ],
            'clientOptions' => [
                // jquery-location-picker options
                'radius'    => 300,
            ]
        ]);
        ?>


        <?=  Html::hiddenInput('coordinate', null, ['id' => 'location_coordinate']); ?>

        <div class="row">
            <?= $form->field($thread, 'anonymous')->checkbox() ?>
            <?= Html::submitButton('Create', ['align' => 'right', 'class' => 'btn btn-lg btn-primary']) ?>

        </div>

    </div>
</div>

<br><br>

<?php ActiveForm::end(); ?>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/js/dashboard-create.js' )?>