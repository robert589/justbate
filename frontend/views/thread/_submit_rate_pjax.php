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
        <!--Rating form part-->
        <?= Html::beginForm('submit-rate', 'post', ['id'=>"ratingForm" ,'data-pjax' => '#submitRating', 'class' => 'form-inline']); ?>
            <?= Html::hiddenInput('thread_id', $thread_id) ?>

            <?php
            if(isset($trigger_login_form) && $trigger_login_form == true){
                echo 'You need to login to perform this action, click ' . Html::a('Login','', ['id' => 'login_link']) ;
            }
            ?>
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
            <div class="col-xs-6" style="text-align: left; height: 100%;">
                <span class="label label-primary"><?= $total_raters ?> Voter(s)</span>
            </div>
        <?= Html::endForm() ?>
</div>

<?php Pjax::end();?>
