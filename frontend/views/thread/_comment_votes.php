<?php

use yii\widgets\Pjax;
use yii\helpers\Html;

$vote_up = ($vote == 1);
$vote_down = ($vote == -1);

Pjax::begin([
    'id' => 'comment_likes_' . $comment_id,
    'timeout' => false,
    'clientOptions'=>[
        'container'=>'comment_likes_' . $comment_id,
    ]
]);

?>


<!-- The vote -->
<!-- The form only be used as refresh page -->
<?= Html::beginForm(["thread/comment-vote" ], 'post', ['id' => 'submitvote-form-' . $comment_id, 'data-pjax' => 'comment_likes_' . $comment_id, 'class' => 'form-inline']); ?>

    <?= Html::hiddenInput("comment_id", $comment_id, ['id' => 'comment_id']) ?>

<div class="col-md-6">
    <div class="col-md-3">
        <?php if($vote_up == true){ ?>
        <?= Html::submitButton("<span class=\"glyphicon glyphicon-arrow-up\"></span>", ['id' => "btn_vote_up_" . $comment_id ,
                                                                                         'class' => 'btn btn-default',
                                                                                        'style'=> 'border:0px solid',
                                                                                        'name' => 'vote',
                                                                                        'value' => 1,
                                                                                        'disabled' => true]) ?>
        <?php } else{ ?>

        <?= Html::submitButton("<span class=\"glyphicon glyphicon-arrow-up\"></span>", ['id' => "btn_vote_up_" . $comment_id ,
            'class' => 'btn btn-default',
            'style'=> 'border:0px solid',
            'name' => 'vote',
            'value' => 1
            ]) ?>

        <?php } ?>
    </div>

    <div class="col-md-3">
        +<?= $total_like ?>
    </div>

    <div class="col-md-3">
        -<?= $total_dislike ?>
    </div>

    <div class="col-md-3">

        <?php if($vote_down){ ?>
            <?= Html::submitButton("<span class=\"glyphicon glyphicon-arrow-down\"></span>", ['id' => "btn_vote_down_" . $comment_id ,
                'class' => 'btn btn-default',
                'style'=> 'border:0px solid',
                'name' => 'vote',
                'value' => -1,
                'disabled' => true]) ?>

        <?php }else{ ?>
            <?= Html::submitButton("<span class=\"glyphicon glyphicon-arrow-down\"></span>", ['id' => "btn_vote_down_" . $comment_id ,
                'class' => 'btn btn-default',
                'style'=> 'border:0px solid',
                'name' => 'vote',
                'value' => -1]) ?>
        <?php } ?>

     </div>

</div>

<?= Html::endForm() ?>

<?php Pjax::end(); ?>