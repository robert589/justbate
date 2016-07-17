<?php

/** @var $radio_button_item_array array **/
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<?php foreach($radio_button_item_array as $value => $text) { ?>
    
    <input type="radio" value="<?= $value ?>" class="btn btn-md btn-warning thread-vote-button-group">
    <label class="thread-vote-button-group-label-<?= $value ?>"> <?= $text ?> </label>

<?php } ?>
