<?php
use yii\widgets\ListView;
use kop\y2sp\ScrollPager;
use kartik\sidenav\SideNav;

use yii\helpers\Html;
/** @var $home \frontend\vo\SiteVo */
/** @var $create_thread_form \frontend\models\CreateThreadForm */
/** @var $add_issue_form \frontend\models\UserFollowIssueForm */
/** @var $change_email_form \frontend\models\ResendChangeEmailForm */
/**
 * Variable used
 */
$issue_followed_by_user = $home->getIssueFollowedByUser();
$trending_topic_list = $home->getTrendingTopicList();
$user_follow_issue = $home->getUserFollowIssue();
$num_followers_of_issue = $home->getNumFollowersOfIssue();
$has_issue = $home->getHasIssue();
$issue_name = $home->getIssueName();
$thread_list_provider = $home->getThreadListProvider();
$popular_issue_list = $home->getPopularIssueList();

$this->title = "Home";
?>

<div class="col-xs-12" style="padding-left: 0;">
	<div class="col-md-3" id="left-sidebar">

		<?= $this->render('home-popular-issue',
						['popular_issue_list' => $popular_issue_list])?>

		<?= $this->render('home-sidenav-issue',
						 ['issue_list' => $issue_followed_by_user,
						  'add_issue_form' => new \frontend\models\UserFollowIssueForm()]) ?>

		<div class="col-xs-12">
			<?= SideNav::widget([
					'type' => SideNav::TYPE_DEFAULT,
					'heading' => 'Trending Topic',
					'items' => $trending_topic_list	]) ?>
		</div>
	</div>

	<div class="col-xs-12 col-md-7 home-main-section">

		<!-- Issue header if exist-->
		<?php if($has_issue){ ?>
		<div class="col-xs-12" style="padding-right: 0;margin-bottom: 10px">
			<?= $this->render('_home_issue-header',
							['issue_name' => $issue_name,
							'issue_num_followers' => $num_followers_of_issue,
							'user_is_follower' => $user_follow_issue]) ?>
		</div>
		<?php }	?>

		<?= $this->render('home-create-thread', ['create_thread_form' => $create_thread_form]) ?>


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

						return $this->render('home-thread-list',[
							'thread' => $thread]
						);
					}])?>
			</div>
		</div>
	</div>

	<div class="col-md-2 hidden-xs">
		<div class="col-md-12" style="margin: 5px">
			<div class="fb-page" data-href="https://www.facebook.com/justbate/" data-tabs="timeline" data-width="180" data-height="150" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true"><blockquote cite="https://www.facebook.com/justbate/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/justbate/">Justbate</a></blockquote></div>
		</div>
		<div class="col-md-12">
			<b></a><?= Html::a("About us", ['site/about'], ['style' => 'font-size:10px']) ?></b>
		</div>
	</div>
</div>

<?php if(!Yii::$app->user->isGuest && $change_email_form->user_email != null ){ ?>
	<?= $this->render('home-verify-email', ['change_email_form' => $change_email_form]) ?>
<?php } ?>
