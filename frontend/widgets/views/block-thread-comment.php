<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$comment_creator_full_name = $thread_comment->getFullName();
$commentator_user_photo_path_link = $thread_comment->getCommentCreatorPhotoLink();
$commentator_vote = $thread_comment->getChoiceText();
?>
<div id="<?= $id ?>">
    <div class="block-thread-comment" data-id="<?= $id ?>">
        <div class="inline image-commentator">
            <img class="img img-circle block-thread-comment-picture profile-picture-comment" style="width: 40px;height:40px;" 
                 src="<?= $commentator_user_photo_path_link ?>">
        </div>
        <div class="block-thread-comment-section">
            <div class="block-thread-comment-name-section">
                
                <div class="inline block-thread-comment-name">
                    <?= $comment_creator_full_name  ?> 
                </div>
                <div class="inline">
                     <?= '&nbsp;' ?> voted <?= $commentator_vote ?>
                </div>
            </div>
            <div class="block-thread-comment-cut-comment">
                <?= $cut_comment ?> . .
            </div>
        </div>
    </div>
    <div class="real-thread-comment block-thread-comment-hide">
        <?= $this->render('../../views/comment/thread-comment', ['thread_comment' => $thread_comment]) ?>
    </div>
</div>
