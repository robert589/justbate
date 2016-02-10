    <?php
    use yii\helpers\Html;
    use yii\widgets\Pjax;
    use kartik\widgets\StarRating;

    ?>

<?php Pjax::begin([
    'id' => 'submitRating',
    'timeout' => false,
    'enablePushState' => false,
    'clientOptions'=>[
        'container' => '#submitRating',
    ]
]);?>

<!--Rating Part-->
<div class="col-md-4">
    <!--Rating form part-->
    <?= Html::beginForm('submit-rate', 'post', ['id'=>"ratingForm" ,'data-pjax' => '#submitRating', 'class' => 'form-inline']); ?>

        <?= Html::hiddenInput('thread_id', $thread_id) ?>

        <!-- Current Rating -->
        <?= StarRating::widget([
            'name' => 'userThreadRate',
            'id' => 'thread_rating',
            'value' => $avg_rating,
            'readonly' => false,
            'pluginOptions' => [
                'showCaption' => true,
                'min' => 0,
                'max' => 5,
                'step' => 1,
                'size' => 'xs',
            ],
            'pluginEvents' => [
            ]
        ])?>
    <?= Html::endForm() ?>


    <!-- Total rater -->
    <div align="center">
        <label> <?= $total_raters ?> Voters </label>
    </div>
</div>

<?php Pjax::end();?>
