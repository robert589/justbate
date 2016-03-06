<?php
use yii\widgets\ListView;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\sidenav\SideNav;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = "Home";
?>
<div class="col-xs-12">
	<div class="col-md-3" id="left-sidebar">
		<div class="col-xs-12">
			<table class="table table-bordered table-responsive" id="left-menu">
				<tr><td><a href=<?= Yii::$app->request->baseUrl . '/site/followee'?>>Your Friend Post</a></td></tr>
			</table>
		</div> <!-- div.co-xs-12 -->

		<div class="col-xs-12">
			<?= SideNav::widget([
				'type' => SideNav::TYPE_DEFAULT,
				'heading' => 'Popular tag',
				'items' => $tag_list,
				]) ?>
			</div><!-- div.col-xs-12 -->

			<div class="col-xs-12">
				<?= SideNav::widget([
					'type' => SideNav::TYPE_DEFAULT,
					'heading' => 'Trending Topic',
					'items' => $trending_topic_list,
					]) ?>
				</div> <!-- div.col-xs-12 -->
			</div><!-- div.col-md-3 -->

			<div id="main-content">
				<div class="col-xs-12 col-md-7" id="create-thread">
					<div class="col-xs-12" id="create-thread-dropdown">
						<div id="create-thread-button"><span>Click Here to Start Make a Thread</span><span style="float: right;" id="icon-dropdown" class="glyphicon glyphicon-chevron-down"></span></div>
					</div> <!-- div.col-xs-12 -->

					<div class="col-xs-12" id="create-thread-form">
						<?= $this->render('_home_create-thread', ['create_thread_form' => $create_thread_form]) ?>
					</div> <!-- div.col-xs-12 -->
				</div>

				<div class="col-xs-12 col-md-7">
					<div class="col-xs-12" id="main-post-desc">
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
					</div><!-- div.col-xs-12 -->
				</div> <!-- div.md-7 -->
			</div> <!-- div.col-md-12 -->
		</div>
