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
<div class="row">
    <div class="col-xs-12 col-md-6" style="float: right:">
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
        ])
        ?>
        <?= Html::hiddenInput('thread_id', $thread_id) ?>
    </div> <!-- div.col-xs-12 -->
    <div class="col-xs-12 col-md-6" style="text-align: left;">
        <span class="label label-primary ">
            <?= $total_raters ?> Voter(s)
        </span> <!-- span.label-primary -->
    </div> <!-- div.col-xs-12.col-md-6 -->
</div> <!-- div.row -->
<?= Html::beginForm('submit-rate', 'post', ['id'=>"ratingForm" ,'data-pjax' => '#submitRating', 'class' => 'form-inline', 'style' => 'float: right;']); ?>
<?= Html::endForm() ?>

<?php Pjax::end();?>
