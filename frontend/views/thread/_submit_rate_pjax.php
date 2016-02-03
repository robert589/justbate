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
    <?= Html::beginForm('thread/submit-vote', 'post', ['id'=>"ratingForm" ,'data-pjax' => '', 'class' => 'form-inline']); ?>

        <?= Html::hiddenInput('thread_id', $thread_id) ?>
        <?= Html::hiddenInput('userThreadRate', null, ['id' => 'userThreadRate']) ?>

    <?= Html::endForm() ?>

    <!-- Current Rating -->
    <?= StarRating::widget([
        'name' => 'rating_2',
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

    <!-- Total rater -->
    <div align="center">
        <label> <?= $total_raters ?> Voters </label>
    </div>
</div>

<?php Pjax::end();?>
