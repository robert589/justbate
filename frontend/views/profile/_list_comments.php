<?php
    use yii\helpers\Html;
    use yii\helpers\HtmlPurifier;
?>

<article>
    <div class="row">
        <div style="font-size: 20px">
            <?= \yii\helpers\Html::a(Html::encode($model['title']), Yii::$app->request->baseUrl . '/thread/'  . $model['thread_id'] . '/' . Html::encode($model['title'])) ?>
        </div>
        <br>
        <?= HtmlPurifier::process($model['comment']) ?>
    </div>
</article>
