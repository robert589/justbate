<?php
/** @var $class string **/
/** @var $items array **/
/** @var $id string **/
/** @var $arg string **/
?>

<div id="<?= $id ?>" data-toggle="buttons">
    <?php foreach($items as $value => $text) { ?>
        <?php if($value === $selected) { ?>
            <label class="btn btn-md btn-warning btn-group <?= $class ?> active disabled"
                   data-arg="<?= $arg ?>" data-label="<?= $value ?>">
        <?php } else { ?>
            <label class="btn btn-md btn-warning <?= $class ?> btn-group" data-arg="<?= $arg ?>"
                   data-label="<?= $value ?>" >
        <?php } ?>
            <input type="radio" value="<?= $value ?>" >
            <div class="simple-button-group-label-<?= $value ?>"> <?= $text ?> </div>
        </label>
    <?php } ?>
</div>