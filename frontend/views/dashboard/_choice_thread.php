<?php
    use yii\helpers\Html;
?>
    <div class="row">

        <div style="float:left">
            <label>Options</label>
        </div>

        <div style="float:right">
            <?= Html::button("<span class=\"glyphicon glyphicon-plus\"></span>",
                ['id' => 'addOption',
                    'class' => 'btn btn-primary'])
            ?>
        </div>
    </div>

    <div class="row">


        <?php foreach($choices as $i => $choice){
            if($i <= 1 ){ ?>

                <div class="col-md-6">
                    <div class="col-md-9">
                        <?= $form->field($choice, "[$i]choice_text")->label(false)?>
                        <?= $form->field($choice, "[$i]index")->hiddenInput(['id' => 'disabled_' . $i, 'value'=> $i ])->label(false) ?>
                        <?= $form->field($choice, "[$i]disabled")->hiddenInput(['id' => 'disabled_' . $i ])->label(false) ?>

                    </div>
                </div>

        <?php }else{ ?>
                <div class="col-md-6" id=<?= 'option_' . $i ?>>
                    <div class="col-md-9">
                        <?= $form->field($choice, "[$i]choice_text")->label(false)?>
                        <?= $form->field($choice, "[$i]disabled")->hiddenInput(['id' => 'disabled_' . $i ])->label(false) ?>
                        <?= $form->field($choice, "[$i]index")->hiddenInput(['id' => 'disabled_' . $i, 'value'=> $i ])->label(false) ?>

                    </div>
                    <div align="col-md-3">
                        <?= Html::button("<span class=\"glyphicon glyphicon-remove\"></span>",
                            ['id' => 'closeOptionButton' . $i,
                                'class' => 'btn btn-danger'])
                        ?>
                    </div>

                </div>
        <?php }} ?>

    </div>

