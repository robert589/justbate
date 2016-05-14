<?php
    use yii\bootstrap\Html;
?>


<article>
    <div class="row">
        <?= Html::a($model['title'], Yii::$app->request->baseUrl . "/thread/" . $model['thread_id'] . '/' . $model['title']) ?>
    </div>
    <div class="row" align="left">
        <?= $model['description'] ?>
    </div>

</article>
