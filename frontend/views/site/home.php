<?php
use yii\widgets\ListView;
use kop\y2sp\ScrollPager;
use kartik\sidenav\SideNav;

/** @var $list_data_provider \yii\data\ArrayDataProvider */
/** @var $issue_list array */
/** @var $trending_topic_list array */
/** @var $create_thread_form \frontend\models\CreateThreadForm */
$this->title = "Home";
?>
<div class="col-xs-12">
	<div class="col-md-3" id="left-sidebar">
		<?php if(!Yii::$app->user->isGuest){ ?>
			<div class="col-xs-12">
				<table class="table table-bordered table-responsive" id="left-menu">
					<tr><td><a href=<?= Yii::$app->request->baseUrl . '/site/followee'?>>Your Friend Post</a></td></tr>
				</table>
			</div> <!-- div.co-xs-12 -->
		<?php } ?>

		<div class="col-xs-12">
			<?= SideNav::widget([
				'type' => SideNav::TYPE_DEFAULT,
				'heading' => 'Popular issue',
				'items' => $issue_list,
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

	<div class="col-md-8 home-main-section" >
		<div class="col-xs-12" id="create-thread">
			<div class="col-xs-12" id="create-thread-dropdown">
				<div id="create-thread-button">Click Here to Start Make a Thread
					<span style="float: right;" id="icon-dropdown" class="glyphicon glyphicon-chevron-down"></span>
				</div>
			</div> <!-- div.col-xs-12 -->

			<div class="col-xs-12" id="create-thread-form">
				<?= $this->render('_home_create-thread', ['create_thread_form' => $create_thread_form]) ?>
			</div> <!-- div.col-xs-12 -->
		</div>

		<div class="col-xs-12 home-thread-list">
			<div class="col-xs-12" id="main-post-desc">
				<?= ListView::widget([
					'id' => 'threadList',
					'dataProvider' => $list_data_provider,
					'summary' => false,
					'itemOptions' => ['class' => 'item'],
					'pager' => [
						'class' => ScrollPager::class,
						'enabledExtensions' => [
							ScrollPager::EXTENSION_TRIGGER,
							ScrollPager::EXTENSION_SPINNER,
							ScrollPager::EXTENSION_NONE_LEFT,
							ScrollPager::EXTENSION_PAGING,
						],
						'triggerOffset' => 100
					],
					'itemView' => function ($model, $key, $index, $widget) {

						$comment = \common\models\ThreadComment::getBestCommentFromThread($model['thread_id']);

						return $this->render('_list_thread',['model' => $model, 'comment' => $comment]);
					}
				])
				?>
			</div><!-- div.col-xs-12 -->
		</div> <!-- div.md-7 -->

	</div> <!-- div.col-md-12 -->

	<?php if(!Yii::$app->user->isGuest){ ?>
		<div id="verify-email">
			<div class="col-xs-12" id="verify-email-dropdown">
				<div id="create-thread-button">Verify Your Email
					<span style="float: right;" id="icon-dropdown" class="glyphicon glyphicon-chevron-down"></span>
				</div>
			</div> <!-- div.col-xs-12 -->

			<div class="col-xs-12" align="center" id="verify-email-form">
				<input type="email" class="form-control" placeholder="Your Email" name="email" />
				<button class="btn btn-default">Verify</button>
			</div> <!-- div.col-xs-12 -->
		</div>
	<?php } ?>

	<div class="col-md-3">
		<?= $this->render('_profile_section') ?>
	</div>
</div>
