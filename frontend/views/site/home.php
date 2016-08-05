<?php
use yii\widgets\ListView;
use kop\y2sp\ScrollPager;
use kartik\dialog\Dialog;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use frontend\widgets\SearchIssue;
/** @var $home \frontend\vo\SiteVo */
/** @var $create_thread_form \frontend\models\CreateThreadForm */
/** @var $add_issue_form \frontend\models\UserFollowIssueForm */
/** @var $change_email_form \frontend\models\ResendChangeEmailForm */
/**
 * Variable used
 */
$issue_followed_by_user = $home->getIssueFollowedByUser();
$issue_followed_by_user_for_sidenav = $home->getIssueFollowedByUserForSidenav();
$trending_topic_list = $home->getTrendingTopicList();
$user_follow_issue = $home->getUserFollowIssue();
$num_followers_of_issue = $home->getNumFollowersOfIssue();
$has_issue = $home->getHasIssue();
$issue_name = $home->getIssueName();
$thread_list_provider = $home->getThreadListProvider();
$popular_issue_list = $home->getPopularIssueList();
$this->title = "Home";
?>

<?php
    Modal::begin(['id' => 'home-search-issue-modal', 'header' => 'Please follow at least 5 issues']);
        echo SearchIssue::widget(['issue_followed_by_user' => $issue_followed_by_user]);
    Modal::end();
?>

<?= Dialog::widget() ?>
	<div class="col-md-2" id="left-sidebar">
            <?= \common\widgets\BlockSidenav::widget([
                'items' => $home->getFeedList(),
                'selected' => $home->getHomeSelected(),
                'id' => 'home-block-sidenav-feed-list'
            ]) ?>
            <?= common\widgets\SimpleSidenav::widget(['id' => 'home-sidenav-followed-issue', 
                'items' => $issue_followed_by_user_for_sidenav,
                'class' => 'col-xs-12',
                'title' => 'Followed Issue',
                'header_btn_id' => 'home-sidenav-followed-issue-edit',
                'header_btn_label' => '<span class="glyphicon glyphicon-edit"></span>']); ?>
      
            <?= common\widgets\SimpleSidenav::widget(['id' => 'home-sidenav-trending-list', 
                'items' => $trending_topic_list,
                'class' => 'col-xs-12',
                'title' => 'Trending Topic']); ?>
        </div>

	<div class="col-xs-12 col-md-7 home-main-section">
            <div class="home-main-section-container col-md-11" >
                
                <?php if($has_issue){ ?>
                <div class="col-xs-12" style="padding-right: 0;margin-bottom: 10px">
                        <?= $this->render('home-issue-header',
                                        ['issue_name' => $issue_name,
                                         'issue_num_followers' => $num_followers_of_issue,
                                         'user_is_follower' => $user_follow_issue]) ?>
                </div>
                <?php } ?>

                <?= $this->render('home-create-thread', ['create_thread_form' => $create_thread_form]) ?>

                <div class="col-xs-12 home-thread-list">
                    <div class="col-xs-12" id="main-post-desc">
                        <?= ListView::widget([
                            'id' => 'home-thread-list',
                            'dataProvider' => $thread_list_provider,
                            'summary' => false,
                            'itemOptions' => ['class' => 'item home-thread-list-item'],
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
	</div>

	<div class="col-md-3 hidden-xs home-right-side">
            <div class="home-right-side-facebook-like">
                <div class="fb-page" data-href="https://www.facebook.com/justbate/" data-tabs="timeline" data-width="240" data-height="150" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true"><blockquote cite="https://www.facebook.com/justbate/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/justbate/">Justbate</a></blockquote></div>
            </div>
            <div class="home-right-side-information">
                <b></a><?= Html::a("About us", ['site/about']) ?></b>
            </div>
	</div>

<?php if(!Yii::$app->user->isGuest && $change_email_form->user_email != null ){ ?>
	<?= $this->render('home-verify-email', ['change_email_form' => $change_email_form]) ?>
<?php } ?>
