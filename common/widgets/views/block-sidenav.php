<?php

use yii\helpers\Html;
$item_class = "block-sidenav-item";
$item_class_block = "block-sidenav-item block-sidenav-item-blocked";
?>

<div class="<?= $class ?>" id="<?= $id ?>" >
    <?php foreach($items as $item) { 
        if($item['label'] ===  $selected) { 
            echo Html::a($item['label'], $item['url'], ['class' => $item_class_block] ); 
        } else {
            echo Html::a($item['label'], $item['url'], ['class' => $item_class] ); 
        } 
    ?>
    <?php } ?>
</div>