<?php
use dosamigos\ckeditor\CKEditor;
use yii\web\JsExpression;

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Dropdown;
use yii\helpers\ArrayHelper;
use yii\app\models\Thread;
use yii\app\models\ThreadTopic;
use pigolab\locationpicker\LocationPickerWidget;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="col-md-12">

	<?= $form->field($thread, 'title') ?>
	

	<?= $form->field($thread, 'content')->widget(CKEditor::className(), [
        'options' => ['rows' => 15],
        'preset' => 'full'
    ]) ?>

	<?= $form->field($thread, 'type')->dropDownList(['Select'=>NULL, 
																'Critique' => 'Kritik', 
																'Petition' => 'Petisi', 
																'Proposal' => 'Proposal']) ?>

  	<?= $form->field($thread, 'topic_id')->dropDownList(['Select'=>NULL, 
															'1' =>'Pendidikan', 
															'2' => 'Politik']) ?>
</div>
<div class="col-md-12">
	
	<div class="col-md-6">
		<?php
    echo $form->field($thread, 'coordinate')->widget('\pigolab\locationpicker\CoordinatesPicker' , [
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
,
		<br>
		<br>
	<div>

</div>

<?= Html::submitButton('Create', ['align' => 'left', 'class' => 'btn btn-lg btn-primary']) ?>

<br>
<br>

<?php ActiveForm::end(); ?>

