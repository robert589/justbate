<?php
//This is inside Pjax,
$thread_link =  Yii::getAlias('@base-url'). '/thread/index?id=' . $model['thread_id'];
?>

Tagged in <a target="_blank" href=<?= $thread_link ?> ><?= $model['title'] ?> </a>
by <a target="_blank" href="<?=  Yii::getAlias('@base-url') . '/profile/index?username=' . $model['username'] ?>"><?= $model['first_name'] . ' ' . $model['last_name'] ?> </a>
<hr>

<?php

    $this->registerJsFile(Yii::$app->request->baseUrl.'/js/_list_notification.js');
?>

