<?php
use yii\widgets\ListView;
use kartik\select2\Select2;


// \Yii::$app->end(print_r($topicData));
?>


<div class="col-md-12">
	<div class="col-md-offset-1 col-md-3">

 
		<label class="control-label">Tag Filter</label>';
		
		<?= Select2::widget([
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
		    							alert(\"Selected\")
		    						}"
		    ]
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