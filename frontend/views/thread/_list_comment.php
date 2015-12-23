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
				<div class="col-md-6">
					<?= Html::a($model['first_name'] . ' ' . $model['last_name'], "#" )?>
				</div>
				<div class="col-md-6">
					<div class="col-md-3">
						<button type="button" class="btn btn-default" style="border:0px solid transparent">
							<span class="glyphicon glyphicon-arrow-up"></span>
				        </button>
					</div>
					<div class="col-md-3">
				        +<?= $model['total_like'] ?>
					</div>
					<div class="col-md-3">
				        -<?= $model['total_dislike'] ?>
					</div>
					<div class="col-md-3">
						<button  type="button" class="btn btn-default" style="border:0px solid transparent">
							<span align="center"class="glyphicon glyphicon-arrow-down"></span>
				        </button>
					</div>
				</div>
			</div>
			<div class="row">
					<?= $model['comment']?>
			</div>
			
		</div>
			

		<br><br><br>
	<br><br><br><br><br><br><br><br><br>
	</article>