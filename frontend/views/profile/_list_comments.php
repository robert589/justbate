<?php
    use yii\helpers\Html;
    use yii\helpers\HtmlPurifier;
?>
<div style="width: 100%">
    
    <div class="thread-link" style="font-size: 20px">
        <?= \yii\helpers\Html::a(Html::encode($model['title']), Yii::$app->request->baseUrl . '/thread/'  . $model['thread_id'] . '/' . Html::encode($model['title'])) ?>
    </div>
    <?= HtmlPurifier::process($model['comment']) ?>

</div>