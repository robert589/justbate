<?php
    /** @var $change_email_form \frontend\models\ResendChangeEmailForm */
    //optional
    /** @var $message-status string */

    use yii\bootstrap\Html;
    use yii\widgets\Pjax;
?>

<?php Pjax::begin([
    'id' => 'change-verify-email-pjax',
    'timeout' => false,
    'enablePushState' => false,
    'clientOptions' => [
        'container' => '#change-verify-email'
    ]
    ]
)

?>
<div id="verify-email">
    <?php $form = \yii\widgets\ActiveForm::begin(['action' => ['site/change-verify-email'],
                                                'method' => 'post',
                                                'id' => 'change-verify-email-form',
                                                'options' => ['data-pjax' => '#change-verify-email'] ]);?>
        <div class="col-xs-12" id="verify-email-dropdown">
            <div id="create-thread-button">Verify Your Email
                <span style="float: right;" id="icon-dropdown" class="glyphicon glyphicon-chevron-down"></span>
            </div>
        </div> <!-- div.col-xs-12 -->

        <div class="col-xs-12" align="center" id="verify-email-form">

            <?= $form->field($change_email_form, 'user_email')->input('text',[
                'placeholder' => 'Your Email',
                'readonly' => true
            ]) ?>

            <?= $form->field($change_email_form, 'command')->hiddenInput()->label(false) ?>

            <?= Html::button('Change',['id' => 'change-unverified-email-button', 'class' => 'btn btn-default']) ?>
            <?= Html::button('Resend',['id' => 'resend-unverified-email-button', 'class' => 'btn btn-default']) ?>
            <hr id="email-separator" />
            <div id="change-verify-email-status">
                <?php if(isset($message)){ ?>
                    <?= $message ?>
                <?php } ?>
            </div>
        </div> <!-- div.col-xs-12 -->
    <?php \yii\widgets\ActiveForm::end() ?>
</div>

<?php Pjax::end() ?>
