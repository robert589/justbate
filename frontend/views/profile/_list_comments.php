<article>
    <div class="row">
        <div style="font-size: 20px">
            <?= \yii\helpers\Html::a($model['title'], Yii::$app->request->baseUrl . '/thread/'  . $model['thread_id']) ?>
        </div>
        <br>
        <?= $model['comment'] ?>
    </div>
</article>
