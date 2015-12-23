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
				<?= Html::a($model['first_name'] . ' ' . $model['last_name'], "#" )?>
			</div>
			<div class="row">
					<?= $model['comment']?>
			</div>
	
		</div>
			

		<br><br><br>
	<br><br><br><br><br><br><br><br><br>
	</article>