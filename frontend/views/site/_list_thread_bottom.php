<?php

    use yii\widgets\Pjax;
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;

    /** @var $thread_id integer */
    /** @var $total_comments integer */
    /** @var $comment_providers \yii\data\ArrayDataProvider */
    /** @var $thread_choice_text array */
    /** @var $user_choice_text string */

?>
<div class="col-xs-12" style="padding-left: 0; padding-right: 0;">

        <?= $this->render('_list_thread_thread_vote', ['thread_choice_text' => $thread_choice_text, 'user_choice_text' => $user_choice_text,
        'thread_id' => $thread_id]) ?>
        <?= $this->render('_list_thread_thread_comment', ['total_comments' => $total_comments,        'thread_id' => $thread_id]) ?>

</div>