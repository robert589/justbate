<?php

/** @var $list array */
/** @var $style string */
/** @var $class string */
/** @var $controller string */
/** @var $id string */
/** @var $name string */
use yii\helpers\Html;
?>
<div class="<?= $class ?>" style="<?= $style ?>" id="<?= $id ?>" >
    <?php foreach($list as $item){ ?>
        <div class="widget-deletable-list-remove-button-container inline" style="opacity:0.4;background-color:greenyellow;;margin-left:15px;white-space: nowrap" >
            <?= $item ?>
            <?= Html::button('<span class="glyphicon glyphicon-remove"></span>',
                            ['class' => 'widget-deletable-list-remove-button',
                             'data-service' => $item,
                             'data-widget-id' => $id,
                             'style' => 'background:none']) ?>
        </div>
    <?php } ?>
    <?= Html::hiddenInput('controller', Yii::$app->request->baseUrl . '/' . $controller, ['class' => 'widget-deletable-list-controller-hidden-input',
                                                        'id' => $id . '-controller-hidden-input']) ?>
    <?= Html::hiddenInput('name', $name, ['id' => $id . '-name']) ?>
</div>
