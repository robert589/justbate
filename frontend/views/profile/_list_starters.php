<?php
    use yii\bootstrap\Html;
    use yii\helpers\HtmlPurifier;
?>


<article>
    <div class="row">
        <?= Html::a(Html::encode($model['title']), Yii::$app->request->baseUrl . "/thread/" . $model['thread_id'] . '/' . Html::encode($model['title'])) ?>
    </div>
    <div class="row" align="left">
        <?= HtmlPurifier::process($model['description']) ?>
    </div>

</article>
