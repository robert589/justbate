<?php
use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\HtmlPurifier;
use common\models\User;
/** @var $model array */
/** @var $comment array */
?>

<article data-service="<?=$model['thread_id'] ?>">
	<div class="col-xs-12" id="thread-issue">
		<?= $this->render('_thread_issues', ['thread_issues' => $thread_issues]) ?>
	</div>
	<div class="col-xs-12 thread-view">
		<div class="col-xs-12 thread-link">
			<div class="col-xs-10 thread-title-list"><?= Html::a(Html::encode($model['title']), Yii::$app->request->baseUrl . '/thread/' . $model['thread_id'] . '/' . str_replace(' ' , '-', strtolower($model['title'])))?></div>
			<div class="col-xs-2" style="font-size: 12pt; text-align: right;">
				<!-- Your share button code -->
				<div class="fb-share-button" data-href="http://justbate.com/thread/<?= $model['thread_id'] ?>/<?= str_replace(' ' , '-', strtolower($model['title'])) ?>" data-layout="button_count"></div>
			</div>
		</div>
		<div class="user-comment-reaction col-xs-12">
			<?php if($comment != null || $comment != false){ ?>
						<div class="col-xs-1" style="width: 50px; margin-left: -15px; margin-bottom: 10px;" style="padding-left: 0; padding-right: 0;"><img src="<?= Yii::getAlias('@image_dir') . '/'. User::findOne(Yii::$app->getUser()->id)->photo_path ?>" height="20px;" /></div>
						<div class="col-xs-11" style="margin-bottom: 10px;"><div class="name-link inline"><?= $comment['first_name'] . ' '. $comment['last_name']  ?> &nbsp; chooses <b><?= $comment['choice_text'] ?></b></div></div>
				<?= HtmlPurifier::process($comment['comment']) ?>
				<?php }else{ ?>
					<?= HtmlPurifier::process($model['description']) ?>
					<?php } ?><hr style="margin-top: 5px; margin-bottom: 5px;" />
				</div>
				<div class="col-xs-12 home-comment-tab">
					<?= $this->render('_list_thread_bottom', [
						'user_choice_text' => $model['choice_text'],
						'thread_id' => $model['thread_id'],
						'thread_choice_text' => $thread_choice_text,
						'total_comments' => $model['total_comments']]) ?>
				</div>
		</div>
</article>
