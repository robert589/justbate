<?php
use yii\widgets\ListView;
use kartik\select2\Select2;
$data = [
		    "red" => "red",
		    "green" => "green",
		    "blue" => "blue",
		    "orange" => "orange",
		    "white" => "white",
		    "black" => "black",
		    "purple" => "purple",
		    "cyan" => "cyan",
		    "teal" => "teal"

];
?>


<div class="col-md-12">
	<div class="col-md-offset-1 col-md-3">

 
		<label class="control-label">Tag Filter</label>';
		
		<?= Select2::widget([
		    'name' => 'color_1',
		    'value' => ['red', 'green'], // initial value
		    'data' => $data,
		    'options' => ['placeholder' => 'Select a color ...', 'multiple' => true],
		    'pluginOptions' => [
		        'tags' => true,
		        'maximumInputLength' => 10
		    ],
		])?>
	</div>
	<div class="col-md-6">
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
		
	</div>
</div>