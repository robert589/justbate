<?php
use yii\widgets\ListView;
use kop\y2sp\ScrollPager;
use kartik\sidenav\SideNav;
use yii\helpers\Html;

/** @var $list_data_provider \yii\data\ArrayDataProvider */
/** @var $issue_list array */
/** @var $trending_topic_list array */
/** @var $create_thread_form \frontend\models\CreateThreadForm */
/** @var $user_email string */
/** @var $issue_name string optional */
/** @var $issue_num_followers integer optional */
/** @var $user_is_follower boolean optional */

/** @var $change_email_form \frontend\models\ChangeEmailForm */

$this->title = "Home";
?>
<div class="col-xs-12" style="padding-left: 0;">
	<div class="col-md-3" id="left-sidebar">
		<div class="col-xs-12">
			<?= SideNav::widget([
				'type' => SideNav::TYPE_DEFAULT,
				'heading' => 'Followed issue',
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

	<div class="col-xs-12 col-md-8 home-main-section">

	<!-- Issue header if exist-->
	<?php if($issue_name != ''){ ?>

		<div class="col-xs-12" style="margin-bottom: 15px;background-color: white">
			<?= $this->render('_home_issue-header', ['issue_name' => $issue_name, 'issue_num_followers' => $issue_num_followers,
													'user_is_follower' => $user_is_follower]) ?>
		</div>

	<?php } ?>

		<?= $this->render('_home_create-thread', ['create_thread_form' => $create_thread_form]) ?>

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
						$thread_issues = \common\models\ThreadIssue::getIssue($model['thread_id']);
						$thread_choice_text = \common\models\Choice::getChoice($model['thread_id']);

						return $this->render('_list_thread',[
							'model' => $model,
							'comment' => $comment,
							'thread_choice_text' => $thread_choice_text,
							'thread_issues' => $thread_issues]
						);
					}
				])
				?>
			</div><!-- div.col-xs-12 -->
		</div> <!-- div.md-7 -->
	</div>
</div>

<?php if(!Yii::$app->user->isGuest && \common\models\User::findOne(['id' => Yii::$app->user->getId()])->validated != 1 ){ ?>
	<?= $this->render('_home_verify-email', ['change_email_form' => $change_email_form]) ?>
<?php } ?>
