<div class="row" style="margin:2px">
    <!-- Yes Comment -->
    <div class="col-md-6">
        <h1 align="center"> YES </h1>
        <?= ListView::widget([
            'dataProvider' => $yesCommentData,
            'options' => [
                'tag' => 'div',
                'class' => 'list-wrapper',
                'id' => 'list-wrapper',
            ],
            'layout' => "\n{items}\n{pager}",

            'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('_list_comment',['model' => $model]);
            },
            'pager' => [
                'firstPageLabel' => 'first',
                'lastPageLabel' => 'last',
                'nextPageLabel' => 'next',
                'prevPageLabel' => 'previous',
                'maxButtonCount' => 3,
            ],
        ]) ?>

    </div>

    <!-- No Comment-->
    <div class="col-md-6">
        <h1 align="center"> NO </h1>
        <?= ListView::widget([
            'dataProvider' => $noCommentData,
            'options' => [
                'tag' => 'div',
                'class' => 'list-wrapper',
                'id' => 'list-wrapper',
            ],
            'layout' => "\n{items}\n{pager}",

            'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('_list_comment',['model' => $model]);
            },
            'pager' => [
                'firstPageLabel' => 'first',
                'lastPageLabel' => 'last',
                'nextPageLabel' => 'next',
                'prevPageLabel' => 'previous',
                'maxButtonCount' => 3,
            ],
        ]) ?>

    </div>
</div>
