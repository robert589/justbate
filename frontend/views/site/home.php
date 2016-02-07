<?php
use yii\widgets\ListView;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\sidenav\SideNav;

use yii\helpers\Html;
//Yii::$app->end(Yii::getAlias('@base-url'));
use yii\helpers\Url;
use nirvana\infinitescroll\InfiniteScrollPager;
use kop\y2sp\ScrollPager;
// \Yii::$app->end(print_r($topicData));
$this->title = "Home | Propose";

?>


<div class="col-md-12">
	<div class="col-md-offset-1 col-md-3" style="margin: 3px">

 
		<label class="control-label">Top Tag</label>
		
		<?=
		 SideNav::widget(['items' => $topicData, 'heading' => false, 'type' =>'default'])
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
			'id' => 'threadList',
   			'dataProvider' => $listDataProvider,

			'pager' => ['class' => \kop\y2sp\ScrollPager::className()],

			'summary' => false,
			'itemOptions' => ['class' => 'item'],

			'layout' => "{summary}\n{items}\n{pager}",

    		'itemView' => function ($model, $key, $index, $widget) {
        		return $this->render('_list_thread',['model' => $model]);
        	}

		]) ?>

		<?= Html::endForm() ?>

		<?php Pjax::end(); ?>
	
	</div>
</div>


<?php	$this->registerJsFile(Yii::$app->request->baseUrl.'/js/home.js'); ?>
