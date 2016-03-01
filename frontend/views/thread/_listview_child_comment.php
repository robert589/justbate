<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ListView;
$comment_id = $model['comment_id'];
//if the person is not guests
if(!empty(\Yii::$app->user->isGuest)){
    $guest = "1";
    $belongs = "0";
}
else{
    if(!empty(\Yii::$app->user->getId())){
        $user_id = \Yii::$app->user->getId();
        //the belongs variable will be used in javascript
        //to set whether edit and delete button will be shown
        if($user_id == $model['user_id']){
            $belongs = "1";
        }
        else{
            $belongs = "0";
        }
    }
    $guest = "0";
}
?>

<br>
<article>
    <div class="box col-md-12" align="left" >
        <div class="row">
            <div class="col-md-6 name_link">
                <?= Html::a($model['first_name'] . ' ' . $model['last_name'], "#" )?>
            </div>
        </div>

        <div class="row">
            <?= $model['comment']?>
        </div>

        <div class="row">
            <!-- Vote -->
            <div class="col-md-3">
                <?= $this->render('_comment_votes', ['comment_id' => $comment_id, 'total_like' => $total_like,
                    'total_dislike' =>$total_dislike, 'vote'=> $vote]) ?>
            </div>
        </div>
        <hr>
    </div>
</article>


<?php
$script =<<< JS
function beginLoginModal(){
		$("#loginModal").modal("show")
			.find('#loginModal')
			.load($(this).attr("value"));
}
// Button voteup child when clicked
$( document ).on( 'click', "#btnVoteUp-child-$comment_id", function () {
    // Do click stuff here
	$("#vote_result_child_$comment_id").val(1);
	if($guest){
		beginLoginModal();
		return false;
	}
	$("#submitvote-form-child-$comment_id").submit();
})
//Button votedown when clicked
.on( 'click', "#btnVoteDown-child-$comment_id", function () {
    // Do click stuff here
	$("#vote_result_child_$comment_id").val(-1);
	if($guest){
		beginLoginModal();
		return false;
	}
	$("#submitvote-form-child-$comment_id"	).submit();
})
JS;
$this->registerJs($script);
?>