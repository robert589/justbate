<?php
    /** @var $signup_model SignUpForm */
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    $append_id = $modal ? "-modal" : "";
?>

<?php   
    $register_form = ActiveForm::begin(['id' => 'process-signup-' . $append_id, 
                                        'method' => 'post', 
                                        'options' => ['enableClientValidation' => true]]);?>
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
                     'id' => 'login-email-register-loading-' . $append_id ])
        ?>
    </div>
    
    <div class="col-xs-12">
        <div class="col-xs-9">
            <button class="btn btn-primary btn-block register-button" id="register-button">
                Submit
            </button>
        </div>
        <div id="cancel-register-button" class="col-xs-3">
            <a href="#" data-service="<?= $append_id ?>" class="btn btn-danger login-email-register-cancel-btn">
                Cancel
            </a>
        </div>
    </div>
<?php ActiveForm::end(); ?>