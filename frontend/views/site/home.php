<?php
use yii\widgets\ListView;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\sidenav\SideNav;

use yii\helpers\Html;

// \Yii::$app->end(print_r($topicData));
$this->title = "Home Page";


?>


<div class="col-md-12">
	<div class="col-md-offset-1 col-md-3">

 
		<label class="control-label">Top Tag</label>';
		
		<?=
		 SideNav::widget(['items' => $topicData, 'heading' => false])
		 ?>

	</div>
	<div class="col-md-6">

		<?php Pjax::begin(['timeout' => false,
							'id' => 'filterHomes',
							'clientOptions' => [
								'container' => '#filterHomes',
							]]); ?>

		<!-- The form only be used as refresh page -->
		<?= Html::beginForm(['site/home'], 'post', ['id' => 'refresh-form', 'data-pjax' => '', 'class' => 'form-inline']); ?>

		<!-- this hidden input will be filled by select2:select event -->
		<?= Html::hiddenInput('filterwords', null, ['id' => 'filter_tag'])?>

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
		
		<?= Html::endForm() ?>

		<?php Pjax::end(); ?>
	
	</div>
</div>


<?php	$this->registerJsFile(Yii::$app->request->baseUrl.'/js/home.js'); ?>
