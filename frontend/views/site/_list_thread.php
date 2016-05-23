<?php
use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\HtmlPurifier;
use common\models\User;
/** @var $thread \common\entity\ThreadEntity */
/** @var $thread_issues array */

/**
 * Used variable
 */
$link_to_thread = $thread->getThreadLink();
$thread_title = $thread->getTitle();
$thread_description = $thread->getDescription();
$thread_id = $thread->getThreadId();
$thread_issues = $thread->getThreadIssues();
$comment_request_url = $thread->getCommentRequestUrl();
$has_chosen_comment = $thread->hasChosenComment();
?>

<article data-service="<?= $thread_id ?>">
	<div class="col-xs-12" id="thread-issue">
		<?= $this->render('../thread/_thread_issues', ['thread_issues' => $thread_issues]) ?>
	</div>
	<br>
	<div class="col-xs-12 thread-view">
		<div class="col-xs-12 thread-link">
			<div class="col-xs-10 thread-title-list" align="center">
				<?= Html::a(Html::encode($thread_title), $link_to_thread)?>
			</div>
			<div class="col-xs-2" style="font-size: 12pt; text-align: right;">
				<div class="fb-share-button" data-href="<?= $link_to_thread ?>" data-layout="button_count">
				</div>
			</div>
		</div>

		<div class="col-xs-11" style="margin-bottom: 10px;" align="left">
			<?= HtmlPurifier::process($thread_description) ?>
		</div>

		<br>

		<div align="center">
		<!-- Voting -->
			<?= $this->render('../thread/_thread_vote',
							 ['thread' => $thread,
							  'submit_thread_vote_form' => new \frontend\models\SubmitThreadVoteForm()])
			?>
			<br><br>
		</div>

		<div class="user-comment-reaction col-xs-12">

		<?php

		if($has_chosen_comment){
			/**
			 * Used Variable
			 */
			$chosen_comment = $thread->getChosenComment();
			$commentator_user_profile_link = $chosen_comment->getCommentatorUserProfileLink();
			$commentator_user_profile_pic_link = $chosen_comment->getCommentatorPhotoLink();
			$commentator_choice = $chosen_comment->getCommentatorChoice();
			$commentator_full_name = $chosen_comment->getFullName();
			$comment  = $chosen_comment->getComment();
		?>

			<div class="col-xs-1"  style=" padding-right: 0;">
				<img src="<?= $commentator_user_profile_pic_link ?>" class="img img-circle" height="40px" width="40px" />
			</div>
			<div class="col-xs-11" style="margin-top: -40px; margin-left: 55px;margin-bottom: 20px">
				<div class="name-link inline">
					<?= $commentator_full_name ?> chose <?= $commentator_choice ?>
				</div>
			</div>

			<div class="home-comment-tab" style="margin-left:0; padding-left: 0">
				<?= $this->render('../thread/_listview_comment_bottom',
								['thread_comment' => $chosen_comment ,
								 'is_thread_comment' => true]) ?>
			</div>

		<?php
		}
		else{
		?>
			<div class="home-comment-tab">
				<?= $this->render('_list_thread_bottom', [
					'thread' => $thread]) ?>
			</div>
		<?php
		}
		?>
		</div>
	</div>
</article>
