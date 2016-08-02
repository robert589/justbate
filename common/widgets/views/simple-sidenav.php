<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
?>
<div class="simple-sidenav-container">
    <div class="simple-sidenav-title">
        <?= $title ?>
        
        <?php if(isset($header_btn_id)) { ?>
            <a class="simple-sidenav-header-button" id="<?= $header_btn_id ?>" href>
                <?= $header_btn_label ?>
            </a>
        <?php } ?>
    </div>
    <div class="<?= $class ?>" id="<?= $id ?>">
        
        <?php foreach($items as $item) {  ?>
            <div class="<?= $item_class ?>">
                <?= Html::a($item['label'], $item['url'], ['class' => 'simple-sidenav-item-link']); ?>
            </div>
                
        <?php } ?>
    </div>
</div>