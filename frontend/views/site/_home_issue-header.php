<?php

    /** @var $issue_name string optional */
    /** @var $issue_num_followers integer */
    /** @var $user_is_follower boolean */

    use yii\helpers\Html;
    use yii\widgets\Pjax;
    use yii\widgets\ActiveForm;
?>

<?php

Pjax::begin([
    'id' => 'follow-issue-pjax',
    'timeout' => false,
    'enablePushState' => false,
    'scrollTo' => false,
    'clientOptions' => [
        'container' => '#follow-issue'
    ]
])

?>
<div class="col-xs-12" style="margin-bottom: 10px">

    <?php $form = ActiveForm::begin(['action' => ['site/follow-issue'],
        'method' => 'post',
        'id' => 'follow-issue-form',
        'options' => ['data-pjax' => '#follow-issue'] ]);?>

        <div style="font-size: 20px;horiz-align: center">
            <h3>
                <?= $issue_name ?>
            </h3>
        </div>

        <div>

            <?php if($user_is_follower !== true){ ?>

            <?= Html::hiddenInput('command', 'follow_issue') ?>
            <?= Html::submitButton('Follow Issue',['class' => 'btn btn-default']) ?>

            <?php }else{ ?>

            <?= Html::hiddenInput('command', 'unfollow_issue') ?>

            <?= Html::submitButton('Unfollow Issue',['class' => 'btn btn-default']) ?>

            <?php } ?>
            <?= $issue_num_followers ?>
        </div>

        <?= Html::hiddenInput('user_id', Yii::$app->user->getId()) ?>

        <?= Html::hiddenInput('issue_name',  $issue_name) ?>

    <?php ActiveForm::end() ?>
</div>

<?php Pjax::end() ?>
