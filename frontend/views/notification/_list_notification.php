<?php
//This is inside Pjax,
$thread_link =  Yii::getAlias('@base-url'). '/thread/index?id=' . $model['thread_id'];
$user_link = Yii::getAlias('@base-url') . '/profile/index?username=' . $model['username'];
?>

Tagged in <a  onclick="window.location ='<?=$thread_link?>' " ><?= $model['title'] ?> </a>
by <a  onclick="window.location = '<?=  $user_link ?>'"><?= $model['first_name'] . ' ' . $model['last_name'] ?> </a>
<hr>

<?php
    $this->registerJsFile(Yii::$app->request->baseUrl.'/js/_list_notification.js');
?>

