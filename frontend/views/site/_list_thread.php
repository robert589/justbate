<?php
	use kartik\rating\StarRating;
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\HtmlPurifier;
	/** @var $model array */

?>

<article>
	<div class="col-xs-12" id="thread-view">
		<div class="col-xs-12 thread-link">
			<?= Html::a(Html::encode($model['title']), Yii::$app->request->baseUrl . '/thread/' . $model['thread_id'])?>
		</div>
		<div class="col-xs-12">
			<?= HtmlPurifier::process($model['description']) ?>
		</div>
		<div class="col-xs-12 home-comment-tab">
			<?= $this->render('_list_thread_comment_part', ['thread_id' => $model['thread_id']]) ?>
		</div>
	</div>
</article>
