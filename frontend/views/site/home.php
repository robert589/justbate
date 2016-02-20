<?php
use yii\widgets\ListView;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\sidenav\SideNav;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

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
			<?= SideNav::widget([
				'type' => SideNav::TYPE_DEFAULT,
				'heading' => 'Popular Keyword',
				'items' => $keyword_list,
			]) ?>
		</div>

		<div class="col-xs-12">

			<?= SideNav::widget([
					'type' => SideNav::TYPE_DEFAULT,
					'heading' => 'Trending Topic',
					'items' => $trending_topic_list,
			]) ?>
		</div>
	</div>
	<div class="col-md-7">
		<div class="col-md-12">
			<?= $this->render('_home_create-thread', ['create_thread_form' => $create_thread_form]) ?>
		</div>

		<div class="col-md-12">
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
		</div>
	</div>
</div>
<?php
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/home.js');
?>
