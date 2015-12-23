<?php
use yii\helpers\Html;
?>

<p> You have successfully entered the following information: </p>

<ul>
	<li><label>First Name</label> : <?=Html:encode($model->first_name) ?></li>
	<li><label>Last Name</label> : <?=Html:encode($model->last_name) ?></li>
	<li><label>Email</label> : <?=Html:encode($model->email) ?></li>
	<li><label>Birthday</label> : <?=Html:encode($model->birthday) ?></li>
</ul>