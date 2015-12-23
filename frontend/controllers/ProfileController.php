<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use frontend\models\EditProfileForm;

/**
 * Profile controller
 */
class ProfileController extends Controller
{

    public function actionIndex()
    {
        
        return $this->render('index');
    }

    public function actionEditProfile()
    {
    	$model = new EditProfileForm();

    	if($model ->load(Yii::$app->request->post()) && $model->validate()){
    		//add sth here
    		return $this->render('edit-confirm',['model'=>$model]);

    	} else{
    		return $this->render('edit',['model'=>$model]);
    	}
    }
}

