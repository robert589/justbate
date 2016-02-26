<?php
?>

<p style="color: black" data-pjax=0><?=  $model['description'] ?> </p>
<hr>


<?php
    $this->registerJsFile(Yii::$app->request->baseUrl.'/frontend/web/js/_list_notification.js');
?>

