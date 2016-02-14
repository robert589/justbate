<?php
use yii\widgets\ListView;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\sidenav\SideNav;

use yii\helpers\Html;
//Yii::$app->end(Yii::getAlias('@base-url'));
use yii\helpers\Url;
use kop\y2sp\ScrollPager;
// \Yii::$app->end(print_r($topicData));
$this->title = "Home | Propose";

?>


<div class="col-md-12">
	<div class="col-md-offset-1 col-md-3" style="margin: 3px">

		<div class="col-xs-12 col-md-3">
			<table class="table table-bordered table-responsive" id="left-menu">
				<thead><td></td></thead>
				<tr><td><button type="button" class="btn">Your Friend<span class="badge">&times;</span></button></td></tr>
				<tr><td><button type="button" class="btn">Popular Thread<span class="badge">&times;</span></button></td></tr>
				<tr><td><button type="button" class="btn">Interesting Thread<span class="badge">&times;</span></button></td></tr>
			</table>
		</div>

		<label class="control-label">Top Tag</label>
		
		<?php
//		 SideNav::widget(['items' => $topicData, 'heading' => false, 'type' =>'default'])

		?>

	</div>
	<div class="col-md-6">

		<div class="row">

			<?php $form = ActiveForm::begin(['action' => 'site/create-thread', 'method' => 'post']) ?>
				<div class="col-xs-8" 	>
					<?= $form->field($create_thread_form, 'title')->textInput(['class' => 'form-control', 'style' => "text-align: center;" ])->label(false) ?>
				</div>
				<div class="col-xs-4" style="text-align: center;">
					<?= $form->field($create_thread_form, 'user_choice')->label(false) ?>
				</div>

				<?= $form->field($create_thread_form, 'description')->textarea(['class' => 'form-control', 'style' => ' height: 175px; width: 100%;'])
					->label(false) ?>

				<div class="col-xs-6">
				</div>

				<div class="col-xs-6">
					<div class="form-group"><div class="checkbox"><label><input name="anonymous" type="checkbox"> Anonymous</label></div></div>
				</div>
				<div style="margin-top: 1%; text-align: center; float: right;">
					<button type="submit" id="create-button" class="btn btn-primary">
						<span id="create-button-label">CREATE</span>
					</button>
				</div>


			<?php ActiveForm::end() ?>

		</div>

		<hr>

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
