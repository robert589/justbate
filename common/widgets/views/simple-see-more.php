<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\HtmlPurifier;
use common\components\Constant;
use yii\helpers\Html;
?>
<div class="simple-see-more-text" id="<?= $id ?>" >
    <?php if($active) { ?>
    <div class="simple-see-more-text-active">
        
        <?= HtmlPurifier::process($cut_text, Constant::DefaultPurifierConfig()) ?>
        <?= Html::button('Read more',['class' => 'simple-see-more-text-link button-like-link inline'
            , 'data-id' => $id ]); ?>
    </div>
    <div class="simple-see-more-text-not-active simple-see-more-text-hide">
        <?= HtmlPurifier::process($text, Constant::DefaultPurifierConfig()) ?>
    </div>
    <?php } else { ?>
        <?= HtmlPurifier::process($text, Constant::DefaultPurifierConfig()) ?>
    <?php } ?>

</div>