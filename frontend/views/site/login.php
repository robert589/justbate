<?php 
    $this->title = 'Login';
    $append_id = $modal ? "-modal" : "";
   
?>
<div class="container-fluid">
    <div class="col-md-12 col-sm-12 login-container">
        <div class="col-xs-12 justbate-image-logo">
            <img src="<?= Yii::$app->request->baseUrl . '/frontend/web/img/logo.png' ?>" style="height:130px">
        </div>
        <div class="col-md-6 col-xs-12 login-register" id="login-register-choice<?= $append_id ?>">
            <a href="<?= Yii::$app->request->baseUrl ?>/site/auth?authclient=facebook" 
               id="login-continue-with-facebook<?= $append_id ?>" 
               class="login-continue-with-facebook"
               data-service="<?= $append_id ?>">
                <span class="input-group register-data">
                    <span class="input-group-addon"><span class="fa fa-facebook"></span></span>
                    <input type="text" class="form-control" value="Continue With Facebook" readonly="true">
                </span>
            </a>
            <a href="#" 
               id="login-register-with-email" 
               class="login-register-with-email"
               data-service="<?= $append_id ?>">
                <span class="input-group register-data">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-envelope"></span>
                    </span>
                    <input type="text" class="form-control" value="Register With Email" readonly="true" >
                </span>
            </a>            
            <hr class="hide-md">
            
        </div>
        <div class="col-md-6 col-xs-12 email-register" id="email-register<?= $append_id ?>">
            <?= $this->render('login-email-register',
                            ['signup_model' => $register_model, 'modal' => $modal]) ?>
            
        </div>

        <div class="col-md-6 col-xs-12 login-form" id="login-form<?= $append_id ?>">
            <?= $this->render('login-login', ['login_model' => $login_model, 'modal' => $modal]) ?>
        </div>
    </div>
</div>
