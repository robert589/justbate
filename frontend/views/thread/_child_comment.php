<?php

// rendered from _listview_comment
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\bootstrap\ActiveForm;
use common\models\CommentVote;
use kartik\dialog\Dialog;
/** @var $comment_id integer */
/** @var $thread_id  integer */
/** @var $belongs boolean */
/** @var $retrieved boolean */
/** @var $child_comment_form \frontend\models\ChildCommentForm */
/** @var $child_comment_provider \yii\data\ArrayDataProvider */

?>

<?php Pjax::begin([
    'timeout' => false,
    'id' => 'child_comment_'  . $comment_id,
    'enablePushState' => false,
    'clientOptions'=>[
        'container'=>'#child_comment_' . $comment_id,
    ]
]) ?>

<?= Dialog::widget(); ?>

<div class="col-md-8">
    <?php if($belongs){ ?>

    <?= Html::button('Edit', ['class' => 'btn btn-primary inline edit_comment', 'data-service' => $comment_id]) ?>
    <?= Html::button('Delete', ['class' => 'btn btn-danger inline delete_comment', 'data-service' => $comment_id]) ?>

    <?php } ?>

    <?= Html::button('Comment', ['class' => 'btn btn-primary inline retrieve-child-comment-btn',
                                'data-service' => $comment_id]) ?>

    <!-- Form for retrieve comment -->
    <?php $form = ActiveForm::begin(['action' => ['thread/get-child-comment'],
        'method' => 'get',
    'options' =>[ 'data-pjax' => '#child_comment_' . $comment_id],
    'id' => 'retrieve-child-comment-form-' . $comment_id])
    ?>
        <?= Html::hiddenInput('comment_id', $comment_id) ?>
        <?= Html::hiddenInput('thread_id', $thread_id) ?>;

    <?php ActiveForm::end() ?>

</div>




<?php if($retrieved){ ?>

<div class="col-xs-12" style="background-color: #dff0d8; " id="<?= 'comment_part_' . $comment_id ?>">
    <div class="col-xs-12" style="margin-top: 15px;" >
        <?= $this->render('_child_comment_input_box', ['comment_id' => $comment_id, 'child_comment_form' => $child_comment_form]) ?>
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


<?php $form = ActiveForm::begin(['action' => ['thread/delete-comment'], 'method' => 'post', 'id' => 'delete_comment_form_' . $comment_id]) ?>
    <?= Html::hiddenInput('comment_id', $comment_id) ?>
    <?= Html::hiddenInput('thread_id', $thread_id) ?>

<?php ActiveForm::end() ?>

<?php Pjax::end() ?>
