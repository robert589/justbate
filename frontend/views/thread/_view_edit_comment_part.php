<?php
    //Rendered from: _listview_comment
    use yii\widgets\Pjax;
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    /** @var $comment_id integer */
    /** @var $comment string */
    /** @var $edit_comment_form \frontend\models\EditCommentForm */
    Pjax::begin([
        'id' => 'edit_comment_' . $comment_id,
        'timeout' => false,
        'enablePushState' => false,
        'clientOptions'=>[
            'container' => '#edit_comment_' . $comment_id,
        ]
    ]);?>

        <div id="comment_shown_part_<?= $comment_id ?>">
            <br>
            <?= $comment ?>
        </div>

        <div id="comment_edit_part_<?= $comment_id ?>" style="display: none" >
            <?php $form = ActiveForm::begin(['action' => ['thread/edit-comment'], 'method' => 'post', 'options' => ['data-pjax' => '#edit_comment_' . $comment_id]])?>
                <br>
                <!-- Cannot use initial value if used with form -->
                <?= \yii\redactor\widgets\Redactor::widget([
                    'name' => 'comment',
                    'value' => $comment,
                    'clientOptions' => [
                        'imageUpload' => \yii\helpers\Url::to(['/redactor/upload/image']),
                    ],
                ]) ?>

                <?= $form->field($edit_comment_form, 'parent_id')->hiddenInput(['value' => $comment_id ])->label(false) ?>

                <div align="right" class="row">
                    <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
                    <?= Html::button('Cancel', ['class' => 'btn btn-danger cancel_edit_comment', 'data-service' => $comment_id]) ?>
                </div>
            <?php ActiveForm::end(); ?>

        </div>

<?php Pjax::end(); ?>




