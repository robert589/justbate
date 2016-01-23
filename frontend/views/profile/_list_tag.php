<?php
$thread_link =  Yii::getAlias('@base-url'). '/thread/index?id=' . $model['thread_id'];
?>
Tagged in <a href=<?= $thread_link ?> ><?= $model['title'] ?> </a>
by <a href="<?=  Yii::getAlias('@base-url') . '/profile/index?username=' . $model['username'] ?>"><?= $model['first_name'] . ' ' . $model['last_name'] ?> </a>
<hr>
