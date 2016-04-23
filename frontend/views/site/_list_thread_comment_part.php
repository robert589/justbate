<?php

use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var $thread_id integer */
/** @var $total_comments integer */
/** @var $comment_providers \yii\data\ArrayDataProvider */
Pjax::begin([
    'id' => 'comment_section_' . $thread_id,
    'enablePushState' => false,
    'timeout' => false,
    'options' => [
        'container' => '#comment_section_' . $thread_id
    ]
])
?>
<div class="col-xs-3" style="padding: 0;">
    <?php
    if(empty($comment_retrieved)){
        $form = ActiveForm::begin(['action' =>['site/get-comment'],
        'method' => 'post',
        'id' => 'get_comment_form_' . $thread_id,
        'options' => [ 'data-pjax' => '#comment_section_' . $thread_id]])
        ?>
        <?= Html::hiddenInput('thread_id', $thread_id) ?>
        <?= Html::submitButton('Comment (' . $total_comments . ')', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end();
    } else { ?>
        <?= Html::button('Hide', ['class' => 'btn btn-primary home_show_hide', 'id' => 'home_show_hide_' . $thread_id, 'data-service' =>  $thread_id ]) ?>
        <?= Html::hiddenInput('total_comments',$total_comments, ['id' => 'hi_total_comments_' . $thread_id]) ?>
        <div class="comment-tab section" id= <?="home_comment_section_" . $thread_id?>>
            <?= $this->render('../thread/_comment_part', ['comment_providers' => $comment_providers]) ?>
        </div>
        <?php } ?>
        <?php Pjax::end(); ?>
    </div>

    <div class="col-xs-3" style="padding: 0;">
        <?php
        Pjax::begin([
            'id' => 'user_reaction' . $thread_id,
            'enablePushState' => false,
            'timeout' => false,
            'options' => [
                'container' => '#user_reaction' . $thread_id
            ]
        ]);

        $action = ActiveForm::begin(['action' =>['site/submit-vote'],
        'method' => 'post',
        'id' => 'user_reaction_' . $thread_id,
        'options' => [ 'data-pjax' => '#user_reaction' . $thread_id]])
        ?>
        <select class="form-control">
            <option>Option 1</option>
            <option>Option 2</option>
        </select>
    </form>
    <?php
    ActiveForm::end();
    Pjax::end();
    ?>
</div>
