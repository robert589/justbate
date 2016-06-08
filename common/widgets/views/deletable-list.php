<?php

/** @var $list array */
/** @var $style string */
/** @var $class string */
use yii\helpers\Html;
?>
<div class="<?= $class ?>" style="<?= $style ?>" >
<?php foreach($list as $item){ ?>

    <div style="opacity:0.4;background-color:greenyellow;;margin-left:15px;white-space: nowrap" class="inline">
        <?= $item ?> <?= Html::button('<span class="glyphicon glyphicon-remove"></span>') ?>
    </div>

<?php } ?>

</div>
