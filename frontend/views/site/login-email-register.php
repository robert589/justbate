<?php
    /** @var $signup_model SignUpForm */
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use yii\widgets\Pjax;
    $append_id = $modal ? "-modal" : "";
?>

<?php Pjax::begin([
    'id' => 'login-email-register-pjax' . $append_id ,
    'timeout' => false,
    'enablePushState' => false,
    'clientOptions' => [
        'data-service' => $append_id,
        'container' => '#login-email-register-form-container' .  $append_id
    ],
    'options' => [
        'class' => 'login-email-register-pjax'
    ]
]) ?>

    <?php   
        $register_form = ActiveForm::begin(['id' => 'login-email-register-form' . $append_id, 
                                            'method' => 'post', 
                                            'action' => ['site/process-signup'],
                                            'enableClientValidation' => true,
                                            'options' => [
                                                'class' => 'login-email-register-form',
                                                'data-service' => $append_id,
                                                'data-pjax' => '#login-email-register-form-container' .  $append_id ]]);?>
        <div class="col-xs-6">
            <?= $register_form->field($signup_model, 'first_name')
                              ->textInput(['placeholder' => 'First Name'], ['class' => 'form-control']) ?>
        </div>
        <div class="col-xs-6">
            <?= $register_form->field($signup_model, 'last_name')
                            ->textInput(['placeholder' => 'Last Name'], ['class' => 'form-control']) ?>
        </div>
        <?= $register_form->field($signup_model, 'email')->textInput(['placeholder' => 'Email Address']) ?>
        <?= $register_form->field($signup_model, 'password')->passwordInput(['placeholder' => 'Your Password']) ?>

        <div align="center" class="col-xs-12">
            <?= Html::img(Yii::$app->request->baseUrl . '/frontend/web/img/loading.gif',
                        ['style' => 'display:none;max-height:50px' ,
                         'id' => 'login-email-register-loading' . $append_id ])
            ?>
        </div>

        <?= Html::hiddenInput('modal', $modal) ?>

        <div class="col-xs-12">
            <div class="col-xs-6">
                <button class="btn btn-primary btn-block register-button login-login-register-submit-btn" id="register-button">
                    Submit
                </button>
            </div>
            <div id="cancel-register-button" class="col-xs-6">
                <button data-service="<?= $append_id ?>" 
                   class="btn-block btn btn-danger login-email-register-cancel-btn">
                    Cancel
                </button>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
<?php Pjax::end() ?>