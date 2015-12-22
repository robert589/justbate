<?php
use yii\widgets\ListView;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

use yii\helpers\Html;

// \Yii::$app->end(print_r($topicData));
?>


<div class="col-md-12">
	<div class="col-md-offset-1 col-md-3">

 
		<label class="control-label">Tag Filter</label>';
		
		<?= Select2::widget([

			'id' => 'selectTag',
		    'name' => 'color_1',
		    'value' => [], // initial value
		    'data' => $topicData,
		    'options' => ['placeholder' => 'Select a color ...', 'multiple' => true],
		    'pluginOptions' => [
		        'tags' => true,
		        'maximumInputLength' => 10
		    ],
		    'pluginEvents' =>[
		    	'select2:select' => "function(){
		    							//get the value
		    							var data = $('#selectTag option:selected').val();
		    							console.log(data);
		    						   	$('#filter_tag').val(data);
		    						   	$('#refresh-form').submit();

		    						}"
		    ]
		])?>
	</div>
	<div class="col-md-6">

		<?php Pjax::begin(); ?>

		<!-- The form only be used as refresh page -->
		<?php $form =ActiveForm::begin(['id' => 'refresh-form']) ?>

		<!-- this hidden input will be filled by select2:select event -->
   		<?= $form->field($filterHomeModel, 'filterwords')->hiddenInput(['id' => 'filter_tag'])->label(false) ?>




		<?= ListView::widget([
   			'dataProvider' => $listDataProvider,
    		'options' => [
        		'tag' => 'div',
        		'class' => 'list-wrapper',
        		'id' => 'list-wrapper',
    		],
  		    'layout' => "{summary}\n{items}\n{pager}",

    		'itemView' => function ($model, $key, $index, $widget) {
        		return $this->render('_list_thread',['model' => $model]);
        	}, 
        	'pager' => [
       	 		'firstPageLabel' => 'first',
        		'lastPageLabel' => 'last',
        		'nextPageLabel' => 'next',
        		'prevPageLabel' => 'previous',
        		'maxButtonCount' => 3,
    		],
		]) ?>
		
		<?php ActiveForm::end()?>

		<?php Pjax::end(); ?>
	
	</div>
</div>