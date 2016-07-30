<?php
    use yii\widgets\ActiveForm;
    use yii\widgets\Pjax;
    use yii\helpers\Html;
    $append_id = $modal ? "-modal" : "";
?>
<?php Pjax::begin([
    'id' => 'login-login-pjax' . $append_id ,
    'timeout' => false,
    'enablePushState' => false,
    'clientOptions' => [
        'data-service' => $append_id,
        'container' => '#login-login-form-container' .  $append_id
    ],
    'options' => [
        'class' => 'login-login-pjax'
    ]
]) ?>

    <?php $form = ActiveForm::begin([
        'id' => 'login-login-form' . $append_id,
        'action' => ['site/process-login'], 
        'method' => 'post', 
        'enableClientValidation' => true,
        'options' => ['data-pjax' => '#login-login-form-container' .  $append_id ]]) ?>

        <div class="col-xs-12">
            <span class="input-group login-data">
                <?= $form->field($login_model, 'email')->textInput(['placeholder' => 'Your Email'], ['class' => 'form-control']) ?>
            </span>
            <span class="input-group login-data">
                <?= $form->field($login_model, 'password')->passwordInput(['placeholder' => 'Your Password'], ['class' => 'form-control']) ?>
            </span>
            <?= yii\helpers\Html::hiddenInput('modal', $modal) ?>
            <div align="center">
                    <?= Html::img(Yii::$app->request->baseUrl . '/frontend/web/img/loading.gif',
                                 ['style' => 'display:none;max-height:50px' ,
                                  'id' => 'login-login-loading' . $append_id ])
                        ?>   
            </div>
            <button id="button-login" data-service="<?= $append_id ?>" class="btn btn-block btn-danger login-login-submit-btn">
                Login
                
            </button>                      
        </div>
    <?php ActiveForm::end() ?>
<?php Pjax::end() ?>