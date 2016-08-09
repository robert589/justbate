<?php
use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="<?= $id ?>" class="button-dropdown-container">
    
    <div class="button-dropdown-popover">
        <?php foreach($items as $item) { ?>
            <?= Html::button($item['label'], ['data-service' => $item['data'], 
                'class' => 'button-dropdown-item ' . $item['class']]) ?>
        <?php } ?> 
    </div>
    <?= Html::button('<span class="glyphicon glyphicon-option-horizontal"></span>', 
                ['class' => 'button-like-link button-dropdown-label', 'data-id' => $id]) ?>
    
</div>

