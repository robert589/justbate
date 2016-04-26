<?php
//retrieve from _list_thread_bottom

use yii\widgets\Pjax;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

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

<?php
    if(!isset($comment_retrieved)){
        $form = ActiveForm::begin(['action' =>['site/get-comment'],
            'method' => 'post',
            'id' => 'get_comment_form_' . $thread_id,
            'options' => [ 'data-pjax' => '#comment_section_' . $thread_id]])
        ?>
            <?= Html::hiddenInput('thread_id', $thread_id) ?>
            <?= Html::submitButton('Comment (' . $total_comments . ')', ['class' => 'btn btn-primary inline', 'style' => 'margin-left:15px' ]) ?>
        <?php ActiveForm::end();
    }
    else { ?>

    <?= Html::button('Hide', ['class' => 'btn btn-primary home_show_hide inline',
            'id' => 'home_show_hide_' . $thread_id,
            'data-service' =>  $thread_id, 'style' => 'margin-left:15px' ]) ?>
    <?= Html::hiddenInput('total_comments',$total_comments, ['id' => 'hi_total_comments_' . $thread_id]) ?>

    <div class="col-xs-12 comment-tab section" id= <?="home_comment_section_" . $thread_id?>>
        <?= $this->render('../thread/_comment_part', ['comment_providers' => $comment_providers]) ?>
    </div>
    <?php } ?>
<?php Pjax::end(); ?>
