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
    }
 }
    
