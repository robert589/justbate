<?php
namespace backend\controllers;

use backend\models\BanThreadForm;
use backend\models\EditChoiceThreadCommentForm;
use backend\models\EditCommentForm;
use common\models\ChildComment;
use common\models\Choice;
use backend\models\EditChoiceForm;
use backend\models\EditThreadForm;
use common\models\ThreadComment;
use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use common\models\Thread;
/**
 * Thread controller
 */
class IssueController extends Controller
{
    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create','list', 'request'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


}
