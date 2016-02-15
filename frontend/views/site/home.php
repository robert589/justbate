<?php
use yii\widgets\ListView;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\sidenav\SideNav;

use yii\helpers\Html;
//Yii::$app->end(Yii::getAlias('@base-url'));
use yii\helpers\Url;
use yii\web\JsExpression;
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

		<div class="col-xs-12">
			<label>Popular Category</label>

			<?= SideNav::widget([
				'type' => SideNav::TYPE_DEFAULT,
				'heading' => 'Options',
				'items' => $category_list,
			]) ?>
		</div>

		<div class="col-xs-12">
			<label>Trending Topic</label>

			<?= SideNav::widget([
					'type' => SideNav::TYPE_DEFAULT,
					'heading' => 'Options',
					'items' => $trending_topic_list,
			]) ?>
		</div>
	</div>
	<div class="col-md-7">
		<?php Pjax::begin([
			'id' => 'createThread',
			'timeout' => false,
			'enablePushState' => false,
			'clientOptions'=>[
				'container' => '#createThread',
			]

		])?>
			<div align="center"> <h3>Create Post</h3></div>

			<?php $form = ActiveForm::begin(['action' => 'create-thread','options' =>['data-pjax'  => '#createThread'] ,'method' => 'post']) ?>
				<div class="col-xs-8" style="padding: 0;">
					<?= $form->field($create_thread_form, 'title')->textInput(['placeholder' => 'Post Title',
						'class' => 'form-control',
						'style' => "text-align: center;" ])->label(false) ?>
				</div>
				<div class="col-xs-3" style="padding-right: 0;">
						<?= $form->field($create_thread_form, 'user_choice')->widget(Select2::className(), [
							'data' => $user_choice,
							'options' => ['placeholder' => 'option ...'],
							'pluginOptions' => [
								'allowClear' => true
							],
						])->label(false); ?>

				</div>
				<div class="col-xs-1">
					<?= Html::submitButton("<span class='glyphicon glyphicon-pencil'></span>", ['class' => 'btn btn-default']) ?>

				</div>
				<?= $form->field($create_thread_form, 'description')->textarea(['placeholder' => 'What are you thinking about it?', 'class' => 'form-control', 'style' => ' height: 175px; width: 100%;'])->label(false) ?>
				<div class="col-xs-5">
					<!-- Topic Name -->
					<?= $form->field($create_thread_form, 'category')->widget(Select2::classname(), [
						'initValueText' => $create_thread_form->category,
						'options' => ['placeholder' => 'Select topic name ...'],
						'pluginOptions' => [
							'minimumInputLength' => 3,
							'allowClear' => true,
							'ajax' => [
								'url' => \yii\helpers\Url::to(['topic-list']),
								'dataType' => 'json',
								'data' => new JsExpression('function(params) { return {q:params.term}; }')
							],
							'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
							'templateResult' => new JsExpression('function(topic_name) { return topic_name.text; }'),
							'templateSelection' => new JsExpression('function (topic_name) { return topic_name.text; }'),
						],
					])->label(false) ?>
				</div>
				<div style="vertical-align: middle;" class="col-xs-3">
					<?= $form->field($create_thread_form, 'anonymous')->checkbox([]) ?>
				</div>
				<div style="vertical-align: middle;" class="col-xs-4"><div style="text-align: center; float: right;">
					<button type="submit" id="create-button" class="btn btn-primary">
						<span id="create-button-label">CREATE</span>
					</button>
				</div></div>
			<?php ActiveForm::end() ?>

		<?php Pjax::end() ?>




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
