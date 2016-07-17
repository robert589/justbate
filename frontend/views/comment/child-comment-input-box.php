<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
/** @var $comment_id integer */
/** @var $child_comment_form \frontend\models\ChildCommentForm */
?>
<?php
/**
 * Used Variable
 */
$last_comment_id_current_user = isset($last_comment_id_current_user) ? $last_comment_id_current_user : null;
?>

<div class="col-xs-12">
    <div class="col-xs-12">
            'id' => 'child-comment-input-box-text-area-' . $comment_id,
            'rows' => 3,
            'cols' => 3,
            'style' => 'width:100%',
            'placeholder' => 'add comment here..' ])
    </div>
    <div class="col-xs-offset-6 col-xs-6">
        <?= Html::button('Submit',
                'data-service' => $comment_id,
                'id' => 'submit-child-comment-submit-button-'  . $comment_id
            ]) ?>
    </div>
</div>
