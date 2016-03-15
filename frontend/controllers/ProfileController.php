<?php
namespace frontend\controllers;

use frontend\models\EditProfileForm;
use frontend\models\FollowerForm;
use frontend\models\UploadProfilePicForm;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

use common\models\User;
use common\models\Comment;
use common\models\Thread;
use common\models\FollowerRelation;


/**
 * Profile controller
 */
class ProfileController extends Controller
{

	public function actionIndex()
	{
		if(isset($_GET['username'])){
			$user = new User();
			$username = $_GET['username'];
			$user->username = $_GET['username'];

			if($user->checkUsernameExist()){
				$user_info =  $user->getUser();

				// Retrieve number of followers
				$num_follower = FollowerRelation::getNumFollowers($user_info['id']);
				$followers = FollowerRelation::getFollowers($user_info['id']);

				// Retrieve number of followings
				$num_following = FollowerRelation::getNumFollowing($user_info['id']);
				$followees = FollowerRelation::getFollowees($user_info['id']);

				$followings_provider = new \yii\data\ArrayDataProvider([
					'allModels' => $followees,
					'pagination' => [
						'pageSize' => 10,
					]
				]);

				$followers_provider = new \yii\data\ArrayDataProvider([
					'allModels' => $followers,
					'pagination' => [
						'pageSize' => 10,
					]
				]);

				//is following
				$is_following = FollowerRelation::isFollowing(Yii::$app->getUser()->id, $user_info['id']);
				//render index
				return $this->render('index', [
					'user' => $user_info,
					'num_followers' => $num_follower,
					'num_following' => $num_following,
					'is_following' => $is_following,
					'num_followings' => $num_following,
					'followings_provider' => $followings_provider,
					'followers_provider' => $followers_provider
				]);
			}
			else{
				Yii::$app->end();
				return $this->render('user-not-found', ['username' => $username]);
			}
		}
		else{
			$username = "";
			return $this->render('user-not-found', ['username' => $username]);
		}

	}

	public function actionEdit(){
		$editForm = new EditProfileForm();
		if($editForm->load(\Yii::$app->request->post()) && $editForm->validate()){
			if($editForm->edit()){
				return $this->redirect(Yii::getAlias('@base-url') . '/profile/index?username=' . User::getUsername(Yii::$app->user->identity->getId()) );
			}
		}
		else{
			return $this->render('edit', ['model' => $editForm]);
		}
	}

	public function actionFollow(){
		if(isset($_POST['follower_id']) && isset($_POST['followee_id'])){
			$follower_id = $_POST['follower_id'];
			$followee_id = $_POST['followee_id'];

			$follower_form = new FollowerForm();
			$follower_form->followee_id = $followee_id;
			$follower_form->follower_id = $follower_id;
			if($follow = $follower_form->update()){
				if($follow == 1){
					return $this->render('_index_follow_button', ['is_following' => $follow , 'followee_id' => $followee_id]);
				}
				else{
					return $this->render('_index_follow_button', ['is_following' => -1, 'followee_id' => $followee_id ]);

				}
			}
			else{
				//error
			}
		}
	}

	public function actionUpload(){
	//	Yii::$app->end("s");
		$model = new UploadProfilePicForm();
		if($model->load(Yii::$app->request->post()) && $model->validate()) {

			$model->imageFile = UploadedFile::getInstance($model, 'imageFile');

			if ($model->upload()) {
				// file is uploaded successfully
				return $this->redirect(Yii::$app->request->baseUrl . '/profile/' . User::getUsername(Yii::$app->user->getId()));
			}
			else{
	//			Yii::$app->end("hello a");
			}
		}
		else{
			if($model->hasErrors()){

//				Yii::$app->end('Error: ' .  print_r($model->getErrors()));
			}
			else{
//				Yii::$app->end('hello');
			}
		}

		return $this->redirect(Yii::$app->request->baseUrl . '/site/error');

	}




}

