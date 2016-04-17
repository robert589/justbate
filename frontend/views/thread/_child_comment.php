<?php

// rendered from
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\bootstrap\ActiveForm;
use common\models\CommentVote;
/** @var $comment_id integer */
/** @var $belongs boolean */

?>

<?php Pjax::begin([
    'timeout' => false,
    'id' => 'child_comment_'  . $comment_id,
    'enablePushState' => false,
    'clientOptions'=>[
        'container'=>'#child_comment_' . $comment_id,
    ]
]) ?>

<div class="col-md-4">
    <?php if($belongs){ ?>
        <?= Html::button('Edit', ['class' => 'btn btn-primary edit_comment', 'data-service' => $comment_id]) ?>
        <?= Html::button('Delete', ['class' => 'btn btn-danger', 'id' => 'delete_comment_' . $comment_id]) ?>
    <?php } ?>

</div>


<div class="col-md-4" align="left" style="padding: 0px">
    <?php if(!isset($retrieved)){ ?>
        <?php $form = ActiveForm::begin(['action' => ['thread/get-child-comment'],
                                        'options' =>[ 'data-pjax' => '#child_comment_' . $comment_id]])
        ?>

        <div align="left">
            <?= Html::hiddenInput('comment_id', $comment_id) ?>
            <?= Html::submitButton('Comment', ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end() ?>

    <?php } else { ?>
        <div align="left">
            <?= Html::button('Hide', ['class' => 'btn btn-default hide_comment', 'data-service' =>  $comment_id ]) ?>
        </div>
    <?php } ?>
</div>

<?php if(isset($retrieved)){ ?>

<div class="col-xs-12" style="background-color: #dff0d8; " id="<?= 'comment_part_' . $comment_id ?>">
    <div class="col-xs-12" style="margin-top: 15px;" >
        <?php $form = ActiveForm::begin(['action' => ['thread/submit-child-comment'], 'id' => "child_comment_form_" . $comment_id,
                                                       'options' =>[ 'data-pjax' => '#child_comment_' . $comment_id]]) ?>

            <?= Html::hiddenInput('user_id', \Yii::$app->getUser()->getId()) ?>
            <?= Html::hiddenInput('parent_id' , $comment_id) ?>
            <?= $form->field($child_comment_form, 'child_comment')->textarea(['class' => 'child_comment_text_area',
                                                                            'data-service' => $comment_id,
                                                                            'rows' => 1,
                                                                            'placeholder' => 'add comment box..' ])
                                                                             ->label(false)?>

        <?php ActiveForm::end() ?>
    </div>

    <div class="col-xs-12">
        <?= ListView::widget([
            'id' => 'threadList',
            'dataProvider' => $child_comment_provider,
            'summary' => false,
            'itemOptions' => ['class' => 'item'],
            'layout' => "{summary}\n{items}\n{pager}",
            'itemView' => function ($model, $key, $index, $widget) {
                $comment_vote_form = CommentVote::getCommentVotesOfComment($model['comment_id'], Yii::$app->getUser()->getId());
                return $this->render('_listview_child_comment',['model' => $model, 'total_like' => $comment_vote_form['total_like'],
                                'total_dislike' => $comment_vote_form['total_dislike'], 'vote' => $comment_vote_form['vote']]);
            }

        ]) ?>
    </div>
</div>


<?php } ?>


<?php Pjax::end() ?>
