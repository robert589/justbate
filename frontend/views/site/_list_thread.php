<?php

	use kartik\rating\StarRating;

use yii\helpers\Html;
use yii\helpers\Url;
      //  Yii::$app->end(print_r($model));

       // $model = $model[0];
?>
	<article>
		<div class="box col-md-12">


			<div class="row">
					<?= Html::a($model['title'], 
					Url::to('../thread/index?id='. $model['thread_id']))?>
			</div>

			
			<div class="row">

			<div class="col-md-5">
				<?= StarRating::widget([
	    			'name' => 'rating_2',
	    			'value' => $model['avg_rating'],
	    			'readonly' => true,
	    			'pluginOptions' => [
	    				'showCaption' => false,
	        			'min' => 0,
	        			'max' => 5,
	        			'step' => 1,
	       	 			'size' => 'xs',

					]])?>
			</div class="col-md-7" align="center center-vertical">
				<p align="right" style="font-size:8px">Created by   <?= $model['first_name']?>  <?=$model['last_name']?> at <?= $model['date_created'] ?></p>


			</div>
			</div>
			
<br><br><br><br>
	</article>

	<hr>