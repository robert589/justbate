<?php

namespace backend\controllers;

use backend\models\PromoteForm;
use common\models\AuthAssignment;
use common\models\AuthItem;
use common\models\User;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class UserController extends Controller
{
    private $isAuth = true;

    public function beforeAction($action)
    {
        if($action->id === "access"){
            if(!Yii::$app->user->can('access_user')){
                $this->isAuth = false;
            }
        }
        else if ($action->id === "promote"){
            if(!Yii::$app->user->can('promote_user')){
                $this->isAuth = false;
            }
        }
        else{
            $this->isAuth = true;
        }
        return true;
    }

    public function actionAccess(){
        // check if user is authenticated
        if($this->isAuth === false){
            return $this->render('/site/prohibit');
        }

        $users = \common\models\User::find()->all();
        $user_provider = new ArrayDataProvider([
            'allModels' => $users,
            'pagination' => [
                'pageSize' => 25
            ]
        ]);
        return $this->render('index', ['user_provider' => $user_provider ]);
    }

    public function actionPromote(){
        // check if user is authenticated
        if($this->isAuth === false){
            return $this->render('/site/prohibit');
        }

        if(isset($_GET['id'])){
            $id = $_GET['id'];

            $promote_form = new \backend\models\PromoteForm();
            $promote_form->user_id = $id;
            if($promote_form->load(Yii::$app->request->post()) && $promote_form->validate()){
                if($promote_form->promote()){
                    return $this->redirect(Yii::$app->request->baseUrl . '/user/access');
                }
            }

            $auth_item = AuthItem::find()->all();
            $auth_item = ArrayHelper::map($auth_item, 'name', 'name');
            $user = User::findOne($id);
            $auth_assignment = AuthAssignment::find()->where(['user_id' => $id])->all();

            return $this->render('promote', ['user' => $user, 'promote_form' => $promote_form, 'auth_item' => $auth_item,
                        'auth_assignment' => $auth_assignment]);
        }
    }
}
?>
