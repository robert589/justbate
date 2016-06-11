<?php
    use yii\bootstrap\Html;
    use yii\helpers\HtmlPurifier;
?>


<article>
    <div>
        <?= Html::a(Html::encode($model['title']), Yii::$app->request->baseUrl . "/thread/" . $model['thread_id'] . '/' . Html::encode($model['title'])) ?>
    </div>
    <div align="left">
        <?= HtmlPurifier::process($model['description']) ?>
    </div>

</article>
