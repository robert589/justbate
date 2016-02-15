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
	<div class="col-md-3">
		<div class="col-xs-12">
			<table class="table table-bordered table-responsive" id="left-menu">
				<tr><td><button type="button" class="btn">Your Friend</button></td></tr>
				<tr><td><button type="button" class="btn">Popular Thread</button></td></tr>
				<tr><td><button type="button" class="btn">Interesting Thread</button></td></tr>
			</table>
		</div>
		<!-- <label class="control-label">Top Tag</label> -->
	</div>
	<div class="col-md-6">
		<div class="row">
			<?php $form = ActiveForm::begin(['action' => 'site/create-thread', 'method' => 'post']) ?>
			<div class="col-xs-6" style="padding: 0;"><?= $form->field($create_thread_form, 'title')->textInput(['placeholder' => 'Post Title', 'class' => 'form-control', 'style' => "text-align: center;" ])->label(false) ?></div>
			<div class="col-xs-6" style="padding-right: 0;"><?= $form->field($create_thread_form, 'user_choice')->textInput(['placeholder' => 'User Choice', 'class' => 'form-control', 'style' => "text-align: center;" ])->label(false) ?></div>
			<?= $form->field($create_thread_form, 'description')->textarea(['placeholder' => 'What are you thinking about it?', 'class' => 'form-control', 'style' => ' height: 175px; width: 100%;'])->label(false) ?>
			<div style="vertical-align: middle;" class="col-xs-6"><div class="form-group"><div class="checkbox"><label><input name="anonymous" type="checkbox"> Post as Anonymous?</label></div></div></div>
			<div style="vertical-align: middle;" class="col-xs-6"><div style="text-align: center; float: right;">
				<button type="submit" id="create-button" class="btn btn-primary">
					<span id="create-button-label">CREATE</span>
				</button>
			</div></div>
			<?php ActiveForm::end() ?>
		</div>
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
				])
			?>
			<?= Html::endForm() ?>
			<?php Pjax::end(); ?>
	</div>
</div>

<?php
	$this->registerJsFile(Yii::$app->request->baseUrl.'/js/home.js');
?>
