<?php

use yii\helpers\Html;
use yii\app\models\Dashboard;
use yii\widgets\LinkPager;
use yii\helpers\Url;

?>


<p>Thread yang anda telah buat:</p>

<ul>
	<?php foreach($rows as $row): ?>
		<li>
		<?= Html::encode("{$row->title}") ?>
		<br>
		<?= Html::encode("{$row->date_created}") ?>
		<br>
		<?= Html::encode("{$row->content}") ?>
		<br>
		<?= Html::a('Edit Thread', ['dashboard/create'], ['class' => 'profile-link']) ?>
		<br>
		<br>
	
		</li>
	<?php endforeach; ?>
</ul>
<?= LinkPager::widget(['pagination' => $pagination]) ?>
<br>
<br>
<?= Html::a('Create New Thread', ['dashboard/create'], ['class' => 'btn btn-primary']) ?>


