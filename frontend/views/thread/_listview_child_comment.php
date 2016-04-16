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

<article>
    <div class="col-xs-3">
        <img class="img img-rounded profile-picture-comment" src="http://www.hit4hit.org/img/login/user-icon-6.png">
    </div>
    <div class="col-xs-9">
        <div class="col-xs-12" id="commentator-name">
           <?= Html::a(Html::encode($model['first_name'] . ' ' . $model['last_name']), Yii::$app->request->baseUrl . "/user/" . $model['username'] )?>
        </div>

        <div class="col-xs-12" id="commentator-comment">
           <?= Html::encode($model['comment'])?>
        </div>

        <div class="col-xs-12" id="commentator-moderate">
                <?= $this->render('_comment_votes', ['comment_id' => $comment_id, 'total_like' => $total_like,
                'total_dislike' =>$total_dislike, 'vote'=> $vote]) ?>
        </div>
    </div>
</article>
