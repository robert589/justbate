<?php
    use yii\widgets\Pjax;
    use yii\helpers\Html;
    use kartik\widgets\Spinner;


    Pjax::begin([
        'id' => 'notifbar',
        'timeout' => false,
        'enablePushState' => false,
        'clientOptions' => [
            'container' => '#notifbar',
        ]
    ]);

     echo Html::beginForm(['../../notification/index'], 'post', ['id' => 'notification-form', 'data-pjax' => '#notifbar', 'class' => 'form-inline']);

     echo "            <ul class='navbar-nav navbar-right nav'>
                            <!-- id notif-expansion is used in js to check whether the dropdown is opened or closed-->";

                        if(isset($recent_notifications_provider)){
                            echo "<li id='notif-expansion' class='dropdown dropdown-large open'>";
                        }
                        else{
                            echo "<li id='notif-expansion' class='dropdown dropdown-large '>";

                        }

    echo "                      <a class='dropdown-toggle' onclick='getNotification()' data-toggle='dropdown'>
                                    <span class='glyphicon glyphicon-alert'>
                                    </span>
                                    <b class='caret'></b>
                                </a>
                                <ul  class='dropdown-menu dropdown-menu-large row'>
                                    <div class='col-md-12'>
                                        <label><div style='width:400px' align='center'> Notifications </div></label>
                                        <hr>";

                        if(isset($recent_notifications_provider)){
                            echo $this->render('_notifications', ['recent_notifications_provider' => $recent_notifications_provider]);
                        }
                        else{
                            echo Spinner::widget(['preset' => 'medium', 'align' => 'center', 'color' => 'blue']);


                        }

    echo  "                        </div>
                                </ul>
                            </li>
                        </ul>
                     ";

    echo  Html::endForm();

    Pjax::end();

?>