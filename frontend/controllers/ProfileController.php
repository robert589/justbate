<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use frontend\models\EditForm;

/**
 * Profile controller
 */
class ProfileController extends Controller
{


    public function actionIndex()
    {
    	
        $user = \Yii::$app->user->identity;
        return $this->render('index');
    }

    public function actionProfile()
    {
        $id = \Yii::app()->user->getId();
        return $this->redirect(array('/user/','id'=>Yii::app()->user->getId()));
    }


	public function actionEdit()
    {
        $model = new EditForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->edit()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->render('edit-confirm');
                }
            }
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    	if($model ->load(Yii::$app->request->post()) && $model->validate()){
    		if($user = $model->edit()){
    			if (Yii::$app->getUser()->login($user)) {
    		//add sth here
    		          return $this->render('edit-confirm',['model'=>$model]);

    			}
    		}
    	} else{
    		return $this->render('edit-profile',['model'=>$model]);
    	}
    }
 }
    
