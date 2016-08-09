<?php
/** @var $class string **/
/** @var $items array **/
/** @var $id string **/
/** @var $arg string **/
/** @var $item_class string **/
?>

<div id="<?= $id ?>" class="<?= $class ?>" data-toggle="buttons">
    <?php foreach($items as $value => $text) { ?>
        <?php if($value === $selected) { ?>
            <label class="simple-radio-button-button btn <?= $item_class ?> active disabled"
                   data-arg="<?= $arg ?>" data-label="<?= $value ?>">
        <?php } else { ?>
            <label class="simple-radio-button-button btn <?= $item_class ?> btn-group" data-arg="<?= $arg ?>"
                   data-label="<?= $value ?>" >
        <?php } ?>
            <input type="radio" value="<?= $value ?>" >
            <div class="simple-button-group-label-<?= str_replace(" ", "-" ,$value) ?>"> <?= $text ?> </div>
        </label>
    <?php } ?>
</div>