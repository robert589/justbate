<?php

use yii\grid\GridView;
use yii\helpers\Html;
use kartik\dialog\Dialog;

$this->title = "Registered Users" ;
?>

<?=
    GridView::widget([
        'dataProvider' => $user_provider,
        'columns' => [
            'photo_path',
            'id',
            'username',
            'auth_key',
            'status',
            'created_at',
            'updated_at',
            'first_name',
            'last_name',
            'notif_last_seen',
            'reputation',
            'facebook_id'
        ],
    ])
?>
