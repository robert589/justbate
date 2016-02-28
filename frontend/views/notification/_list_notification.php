<?php
?>

<span class="glyphicon glyphicon-comment"></span><span id="notification-label" data-pjax=0><?=  $model['description'] ?> </span><hr />


<?php
    $this->registerJsFile(Yii::$app->request->baseUrl.'/frontend/web/js/_list_notification.js');
?>
