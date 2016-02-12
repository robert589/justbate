<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\bootstrap\ActiveForm;
use common\models\CommentVote;

$this->registerJsFile(Yii::$app->request->baseUrl    . '/js/jquery.js');
?>

<?php Pjax::begin(['timeout' => false,
    'id' => 'child_comment_'  . $comment_id,
    'enablePushState' => false,
    'clientOptions'=>[
        'container'=>'#child_comment_' . $comment_id,
    ]
]) ?>



<?php if(!isset($retrieved)){ ?>

    <div class="col-md-12">
        <div class="row">
            <?php $form = ActiveForm::begin(['action' => ['thread/get-child-comment'],
                                                'options' =>[ 'data-pjax' => '#child_comment_' . $comment_id]]) ?>
                <div align="right">

                    <?= Html::hiddenInput('comment_id', $comment_id) ?>

                    <?= Html::submitButton('Comment', ['class' => 'btn btn-default']) ?>
                </div>

            <?php ActiveForm::end() ?>
        </div>
    </div>

<?php }else{ ?>
    <div class="col-md-12">
            <div class="row" align="right">
                <?= Html::button('Hide', ['class' => 'btn btn-default', 'id' => 'hide_button_' . $comment_id ]) ?>
            </div>

            <div class="row" id="<?= 'comment_part_' . $comment_id ?>">
                <div class="col-md-12" >
                    <?php $form = ActiveForm::begin(['action' => ['thread/submit-child-comment'], 'id' => "child_comment_form_" . $comment_id,
                                                                   'options' =>[ 'data-pjax' => '#child_comment_' . $comment_id]]) ?>

                        <?= Html::hiddenInput('user_id', \Yii::$app->getUser()->getId()) ?>

                        <?= Html::hiddenInput('parent_id' , $comment_id) ?>

                        <?= $form->field($child_comment_form, 'child_comment')->textarea(['id' => 'child_comment_text_area_' . $comment_id,
                                                                                        'rows' => 3, 'placeholder' => 'add comment box..' ])
                                                                                            ->label(false)?>

                    <?php ActiveForm::end() ?>
                </div>
                <div class="col-md-12">
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


    </div>
<?php } ?>


<?php Pjax::end() ?>



<?php
$script =<<< JS
    $(document).on('keydown', "#child_comment_text_area_$comment_id", function(event){
        if(event.keyCode == 13){
            $("#child_comment_form_$comment_id").submit();
            return false;
        }
    }).on('focus','#child_comment_text_area_$comment_id', function(){
         if(this.value == "Add comment here..."){
             this.value = "";
        }
    }).on('blur','#child_comment_text_area_$comment_id', function(){
        if(this.value==""){
            this.value = "Add comment here...";
        }
    }).on('click','#hide_button_$comment_id'  ,function(){
        if($("#hide_button_$comment_id").text() == "Hide"){
            $("#comment_part_$comment_id").hide();
            $("#hide_button_$comment_id").text("Show");
        }
        else{
            $("#comment_part_$comment_id").show();
                        $("#hide_button_$comment_id").text("Hide");

        }
    });
JS;
$this->registerJs($script);
?>
