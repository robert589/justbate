<?php
/** @var $navigationText array */
/** @var $requestUrl string */
/** @var $id string */
/** @var $perPage string */
/** @var $totalCount int */
use \yii\helpers\Html;
?>

<div class="col-xs-12" id="<?= $id . '-item-list' ?>">
</div>

<hr>
<?php if($totalCount >= $perPage) { ?>
<div class="col-xs-12" id="<?= $id . '-load-btn-container' ?>">
    <?= Html::button($navigationText, ['data-url' => $requestUrl, 
                                        'data-arg' => $id, 'class' =>'infinite-scroll-load-btn',
                                        'align' => 'left']) ?>
</div>

<?php } ?>

<?= Html::hiddenInput('page', 1, ['id' => $id . '-current-page'] ) ?>
<?= Html::hiddenInput('per-page', $perPage, ['id' => $id . '-per-page'] ) ?>
<?= Html::hiddenInput('total-count', $totalCount, ['id' => $id . '-total-count']) ?>

