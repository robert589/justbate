<?php
    use yii\helpers\Html;
?>

<div class="col-xs-12">
    <div class="row" id="home-issue-edit-header">
        Search issue
    </div>
    <div class="row" id="home-issue-edit-input-text">
        <?= Html::textInput('issue-query', null,['placeholder' => 'Search Issue', 'class' => 'form-control']) ?>
    </div>
</div>

