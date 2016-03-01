<?php
	use kartik\rating\StarRating;
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;


?>

<article>

	<div class="box col-md-12" style="min-height:250px;background-color: " >
		<hr style="border-top: 2px solid #8c8b8b;">

		<div class="col-xs-12" style="font-size: 20px;, line-height: 40px !important;">
			<?= Html::a($model['title'], Url::to('../thread/index?id='. $model['thread_id']))?>
		</div>
		<div class="col-xs-12">
			<?= $model['description'] ?>
		</div>
		<div>
			<?= $this->render('_list_thread_comment_part', ['thread_id' => $model['thread_id']]) ?>
		</div>
	</div>

</article>
