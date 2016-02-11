<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\bootstrap\ActiveForm;


$this->registerJsFile(Yii::$app->request->baseUrl    . '/js/jquery.js');
?>

<?php Pjax::begin(['timeout' => false,
    'id' => 'child_comment_'  . $comment_id,
    'enablePushState' => false,
    'clientOptions'=>[
        'container'=>'#child_comment_' . $comment_id,
    ]
]) ?>

<?php if(!isset($retrieved)){ ?>

    <div class="col-md-12">
        <div class="row">
            <?php $form = ActiveForm::begin(['action' => ['thread/get-child-comment'],
                                            'options' =>[ 'data-pjax' => '#child_comment_' . $comment_id]]) ?>
                <div align="right">

                    <?= Html::hiddenInput('comment_id', $comment_id) ?>

                    <?= Html::submitButton('Comment', ['class' => 'btn btn-default']) ?>
                </div>

            <?php ActiveForm::end() ?>
        </div>
    </div>

<?php }else{ ?>
    <div class="col-md-12">
            <div class="row" align="right">
                <?= Html::button('Hide', ['class' => 'btn btn-default', 'id' => 'hide_button_' . $comment_id ]) ?>

            </div>
            <div class="row" id="<?= 'comment_part_' . $comment_id ?>">
                <div class="col-md-12" >
                    <?php $form = ActiveForm::begin(['action' => ['thread/submit-child-comment'],
                                                                   'options' =>[ 'data-pjax' => '#child_comment_' . $comment_id]]) ?>

                        <?= $form->field($child_comment_form, 'child_comment')->textarea(['rows' => 3, 'placeholder' => 'add comment box..' ]) ?>

                    <?php ActiveForm::end() ?>
                </div>
                <div class="col-md-12">
                    <?= ListView::widget([
                        'id' => 'threadList',
                        'dataProvider' => $child_comment_provider,

                         'summary' => false,
                        'itemOptions' => ['class' => 'item'],

                        'layout' => "{summary}\n{items}\n{pager}",

                        'itemView' => function ($model, $key, $index, $widget) {
                            return $this->render('_listview_child_comment',['model' => $model]);
                        }

                    ]) ?>

                </div>
            </div>


    </div>
<?php } ?>


<?php Pjax::end() ?>



<?php
$script =<<< JS

JS;
$this->registerJs($script);
?>
