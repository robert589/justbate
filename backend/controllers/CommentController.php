<?php
namespace backend\controllers;

use backend\models\BanCommentForm;
use backend\models\EditChoiceThreadCommentForm;
use backend\models\EditCommentForm;
use common\models\ChildComment;
use common\models\Choice;
use common\models\ThreadComment;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
/**
 * Thread controller
 */
class CommentController extends Controller
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
                        'actions' => ['edit','edit-child', 'banned'],
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

    public function actionBanned(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $ban_comment_form = new BanCommentForm();
            $ban_comment_form->comment_id = $id;
            if(!$ban_comment_form->update()){
                return $this->redirect(Yii::$app->request->baseUrl . '/site/error');
            }
            return $this->redirect(Yii::$app->request->baseUrl . '/site');

        }
        else{
            return $this->redirect(Yii::$app->request->baseUrl . '/site/error');
        }

    }

    public function actionEditChild(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $child_comment = ChildComment::getComment($id);

            $edit_comment_form = new EditCommentForm();
            $edit_comment_form->comment_id = $id;

            if($edit_comment_form->load(Yii::$app->request->post()) ){
                if($edit_comment_form->update()){
                    return $this->redirect(Yii::$app->request->baseUrl . '/site/child-comment');
                }
                else{

                }


            }
            else{
                if($edit_comment_form->hasErrors()){
                    Yii::$app->end(print_r($edit_comment_form->getErrors()));
                }

            }

            return $this->render('edit-child', [
                'comment' => $child_comment,
                'edit_comment_form' => $edit_comment_form,
            ]);
        }
        else{
            return $this->redirect(Yii::$app->request->baseUrl . '/site/error');
        }

    }

    public function actionEdit(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $thread_comment = ThreadComment::getComment($id);

            $edit_comment_form = new EditCommentForm();
            $edit_comment_form->comment_id = $id;

            $edit_choice_thread_comment_form = new EditChoiceThreadCommentForm();
            $edit_choice_thread_comment_form->comment_id = $id;
            $edit_choice_thread_comment_form->old_choice_text = $thread_comment['choice_text'];
            $edit_choice_thread_comment_form->thread_id = $thread_comment['thread_id'];

            $choice = Choice::find()->where(['thread_id' => $thread_comment['thread_id']])->all();
            $choice = ArrayHelper::map($choice, 'choice_text', 'choice_text');
            if($edit_comment_form->load(Yii::$app->request->post()) && $edit_choice_thread_comment_form->load(Yii::$app->request->post())){
                if($edit_comment_form->update()){
                    if(!$edit_choice_thread_comment_form->update()){
                        //errro
                    }
                    else{
                       return $this->redirect(Yii::$app->request->baseUrl . '/site/thread-comment');
                    }
                }
                else{

                }


            }
            else{
                if($edit_comment_form->hasErrors()){
                    Yii::$app->end(print_r($edit_comment_form->getErrors()));
                }
                if($edit_choice_thread_comment_form->hasErrors()){
                    Yii::$app->end(print_r($edit_choice_thread_comment_form->getErrors()));
                }
            }

            return $this->render('edit', [
                'comment' => $thread_comment,
                'edit_comment_form' => $edit_comment_form,
                'choice' => $choice,
                'edit_choice_thread_comment_form' => $edit_choice_thread_comment_form
            ]);
        }
        else{
            return $this->redirect(Yii::$app->request->baseUrl . '/site/error');
        }
    }
    
}
