<?php

use yii\helpers\Html;
?>

<p>Anda telah memasukkan informasi di bawah ini:<p>

<ul>
	<li><label>Judul</label>: <?= Html::encode($thread->title) ?></li>
	<li><label>Kategori</label>: <?= Html::encode($thread->type)?></li>
	<li><label>Topik</label>: <?= Html::encode($thread->topic)?></li>
	<li><label>Isi</label>: <?= Html::encode($thread->content) ?></li>
</ul>