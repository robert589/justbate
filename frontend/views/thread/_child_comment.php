<?php

use yii\widgets\Pjax;
use yii\helpers\Html;


Pjax::begin([
    'id' => 'submitComment-' . $comment_id,
    'timeout' => false,
    'clientOptions' => [
        'container' => '#submitComment-' . $comment_id,
    ]
]);
?>

<div class="row">
    <?= Html::beginForm(['thread/submit-child-comment'], 'post', ['id'=>"childForm-$comment_id" ,'data-pjax' => '#submitComment-' . $comment_id, 'class' => 'form-inline']); ?>

        <?= Html::hiddenInput('commentRetrieved', 0, ['id' => 'commentRetrieved-'.$comment_id]) ?>

        <?= Html::hiddenInput('commentShown', 0, ['id' => 'commentShown-'.$comment_id]) ?>

        <?= Html::hiddenInput('parent_id', $comment_id) ?>
        <!--Comment box form here-->
        <?= Html::textarea('childComment', null, ['class'=> 'form-control', 'id' => "child-comment-box-$comment_id",
            'placeholder' => 'add comment box', 'rows' => 3, 'style' => 'min-width:100%;display:none' ]) ?>

    <?= Html::endForm() ?>
</div>

<br>

<?php

Pjax::begin([
    'id' => 'childCommentData-'.$comment_id,
    'timeout' => false,
    'enablePushState' => false,
    'clientOptions'=>[
        'container' => '#childCommentData-' . $comment_id,
        'linkSelector'=>'#retrieveComment'.$comment_id
    ]
]);

?>

<div  class="row">

    <div align="right">

        <!--Delete and Edit Part-->
        <?php if($belongs) { ?>
            <?= Html::button('Delete', ['id' => "deleteComment$comment_id", 'class' => 'btn btn-default' ]) ?>

            <?= Html::button('Edit', ['id' => "editComment$comment_id", 'class' => 'btn btn-default']) ?>
        <?php }else{ ?>
            <?= Html::button('Delete', ['id' => "deleteComment$comment_id", 'class' => 'btn btn-default', 'style' => 'display:none']) ?>

            <?= Html::button('Edit', ['id' => "editComment$comment_id", 'class' => 'btn btn-default', 'style' => 'display:none']) ?>

        <?php } ?>

        <?= Html::button('Reply', ['id' => "showChildCommentBox$comment_id", 'class' => 'btn btn-default']) ?>

        <!-- Retrieve, Hide and Show Part-->
        <?php if(!isset($retrieveChildData)){ ?>
            <?= Html::a('Retrieve Comment', ["../../thread/index?id=" . $thread_id . "&comment_id=" . $comment_id],
                ['data-pjax' => '#childCommentData-'.$comment_id, 'class' => 'btn btn-default'
                    ,'id' => 'retrieveComment' . $comment_id]) ?>
        <?php } else{ ?>
            <?= Html::button('Hide', ['id' => "hideButton$comment_id", 'class' => 'btn btn-default']) ?>

        <?php } ?>
    </div>

    <?php $listviewid = "listviewChild" . $comment_id ?>
    <div id=<?= $listviewid ?> class="col-md-12" style="border-left: solid #e0e0d1;" >

        <?php if(isset($retrieveChildData)){ ?>
            <?= ListView::widget([
                'dataProvider' => $retrieveChildData,
                'options' => [
                    'tag' => 'div',
                    'class' => 'list-wrapper',
                    'id' => 'list-wrapper',
                ],
                'layout' => "\n{items}\n{pager}",

                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_listview_child_comment',['model' => $model]);
                },
                'pager' => [
                    'firstPageLabel' => 'first',
                    'lastPageLabel' => 'last',
                    'nextPageLabel' => 'next',
                    'prevPageLabel' => 'previous',
                    'maxButtonCount' => 3,
                ],
            ]) ?>

        <?php } ?>


    </div>
</div>
<?php Pjax::end();?>
<br>
<hr>

<?php Pjax::end();?>



<?php
$script =<<< JS

//Begin edit modal
function beginEditModal$comment_id(){
	console.log($comment_id);
	$("#editModal-$comment_id").modal("show")
			.find('#editModal-$comment_id')
			.load($(this).attr("value"));
}

$( document ).on( 'click', "#showChildCommentBox$comment_id", function () {
    // Do click stuff here

  	$("#child-comment-box-$comment_id").show();
})
.on('click', "#editComment$comment_id", function(){
	beginEditModal$comment_id();

	return false;
})
.on( 'click', "#btnVoteUp-$comment_id", function () {
    // Do click stuff here
	$("#vote_result_$comment_id").val(1);
	if($guest){
		beginLoginModal();
	}
	$("#submitvote-form-$comment_id"	).submit();
})
.on( 'click', "#btnVoteDown-$comment_id", function () {
    // Do click stuff here
	$("#vote_result_$comment_id").val(-1);
	if($guest){
		beginLoginModal();
	}
	$("#submitvote-form-$comment_id"	).submit();
})
.on( 'click', "#comment_id", function () {
    // Do click stuff here
  	$("#child-comment-box-$comment_id").show();
})
.on( 'click', "#hideButton$comment_id", function () {
    if($("#hideButton$comment_id").text() == 'Hide'){
  		$("#listviewChild$comment_id").hide();
  		$("#hideButton$comment_id").text('Show');
  	}else{
  		$("#listviewChild$comment_id").show();
  		$("#hideButton$comment_id").text('Hide');
  	}
})
.on('keydown', '#child-comment-box-$comment_id', function(event){
    if (event.keyCode == 13) {
    	if($guest){
			beginLoginModal();
		}
		else{
        	$("#childForm-$comment_id").submit();
    	}
        return false;
     }
})

$(document).pjax('retrieveComment' + $comment_id, '#childCommentData-' + $comment_id, { fragment: '#childCommentData-' + $comment_id });
JS;
$this->registerJs($script);
?>