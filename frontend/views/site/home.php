<?php
use yii\widgets\ListView;
use kop\y2sp\ScrollPager;
use kartik\sidenav\SideNav;
/** @var $home \common\entity\HomeEntity */
/** @var $create_thread_form \frontend\models\CreateThreadForm */
/** @var $add_issue_form \frontend\models\UserFollowIssueForm */
/** @var $change_email_form \frontend\models\ResendChangeEmailForm */
/**
 * Variable used
 */
$issue_followed_by_user = $home->getUserFollowedIssueList();
$trending_topic_list = $home->getTrendingTopicList();
$user_follow_issue = $home->isUserFollowedIssue();
$num_followers_of_issue = $home->getIssueNumFollowers();
$has_issue = $home->hasIssue();
$issue_name = $home->getIssueName();
$thread_list_provider = $home->getThreadList();
$popular_issue_list = $home->getPopularIssueList();
$this->title = "Home";
?>



<div class="col-xs-12" style="padding-left: 0;">
	<div class="col-md-3" id="left-sidebar">

		<?= $this->render('_home_popular-issue',
						['popular_issue_list' => $popular_issue_list,
						])
		?>

		<?= $this->render('_home_sidenav-issue',
							['issue_list' => $issue_followed_by_user,
							 'add_issue_form' => new \common\models\UserFollowedIssue()]) ?>

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
		<?php

		if($has_issue){

		?>

		<div class="col-xs-12" style="padding-right: 0;margin-bottom: 10px">
			<?= $this->render('_home_issue-header',
							['issue_name' => $issue_name,
							'issue_num_followers' => $num_followers_of_issue,
							'user_is_follower' => $user_follow_issue]) ?>
		</div>

		<?php
		}
		?>

		<?= $this->render('_home_create-thread', ['create_thread_form' => $create_thread_form]) ?>


		<div class="col-xs-12 home-thread-list">

			<div class="col-xs-12" id="main-post-desc">
				<?= ListView::widget([
					'id' => 'threadList',
					'dataProvider' => $thread_list_provider,
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
						'triggerOffset' => 100,
					],
					'itemView' => function ($thread, $key, $index, $widget) {

						return $this->render('_list_thread',[
							'thread' => $thread]
						);
					}
				])
				?>
			</div><!-- div.col-xs-12 -->
		</div> <!-- div.md-7 -->
	</div>
</div>

<?php if(!Yii::$app->user->isGuest && $change_email_form->user_email != null ){ ?>
	<?= $this->render('_home_verify-email', ['change_email_form' => $change_email_form]) ?>
<?php } ?>
