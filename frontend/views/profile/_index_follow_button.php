<?php
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

Pjax::begin([
    'id' => 'follow_button',
    'timeout' => false,
    'enablePushState' => false,
    'options' => [
        'container' => '#follow_section_button'
    ]
])


?>


<?php
if($followee_id !== Yii::$app->getUser()->id) {
    $form = ActiveForm::begin(['action' => ['profile/follow'], 'method' => 'post', 'options' => ['data-pjax' => '#follow_section_button']]) ?>

    <?= Html::hiddenInput('followee_id', $followee_id) ?>
    <?= Html::hiddenInput('follower_id', Yii::$app->getUser()->id) ?>


    <?php if ($is_following == 1) { ?>
        <?= Html::submitButton('Unfollow', ['class' => 'btn btn-danger']) ?>
        <?php } else { ?>
            <?= Html::submitButton('Follow', ['class' => 'btn btn-primary']) ?>
            <?php } ?>

            <?php ActiveForm::end();
        }
        ?>

        <?php
        Pjax::end();
        ?>
