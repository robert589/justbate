<?php
namespace frontend\controllers;

use common\models\ThreadComment;
use frontend\models\EditProfileForm;
use frontend\models\FollowerForm;
use frontend\models\UploadProfilePicForm;

use Yii;
use yii\data\ArrayDataProvider;
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

	const THREAD_STARTERS = 'starters';
	const COMMENTS = 'comments';
	const FOLLOWERS = 'followers';
	const FOLLOWEES = 'followees';
	const NOTHING = '';

	/**
	 * @return string
	 */
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

				// Retrieve number of followings
				$num_following = FollowerRelation::getNumFollowing($user_info['id']);

				//is following
				$is_following = FollowerRelation::isFollowing(Yii::$app->getUser()->id, $user_info['id']);

				$model_provider = null;

				if(isset($_GET['attr'])) {
					$attr = $_GET['attr'];
					if ($attr == self::THREAD_STARTERS) {
						$model_provider = $this->getStarters($user_info['id']);
					}
					else if($attr == self::COMMENTS){
						$model_provider = $this->getComments($user_info['id']);
					}
					else if($attr == self::FOLLOWEES){
						$model_provider = $this->getFollowees($user_info['id']);
					}
					else if($attr == self::FOLLOWERS){
						$model_provider = $this->getFollowers($user_info['id']);
					}

					$type = $attr;
				}

				else{
					$type = self::COMMENTS;
					$model_provider = $this->getComments($user_info['id']);
				}

				return $this->render('index', [
					'user' => $user_info,
					'num_followers' => $num_follower,
					'num_followings' => $num_following,
					'is_following' => $is_following,
					'model_provider' => $model_provider,
					'type' => $type
				]);
			}
			else{
				return $this->render('user-not-found', ['username' => $username]);
			}
		}
		else{
			$username = "";
			return $this->render('user-not-found', ['username' => $username]);
		}

	}

	/**
	 * @return string|\yii\web\Response
	 */
	public function actionEdit(){
		$editForm = new EditProfileForm();
		if($editForm->load(\Yii::$app->request->post()) && $editForm->validate()){
			if($editForm->edit()){
				return $this->redirect(Yii::$app->request->baseUrl . '/profile/user/' . User::getUsername(Yii::$app->user->identity->getId()) );
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
		return null;
	}

	private function getStarters($user_id){

		$thread = Thread::getThreadStartersByUserId($user_id);

		$model_provider = new ArrayDataProvider([
			'allModels' => $thread,
			'pagination' => [
				'pageSize' => 10,
			]
		]);

		return $model_provider;

	}


	private function getComments($user_id){

		$thread_comments = ThreadComment::getThreadCommentsByUserId($user_id);

		$comment_provider = new \yii\data\ArrayDataProvider([
			'allModels' => $thread_comments,
			'pagination' => [
				'pageSize' => 10,
			]
		]);
		return $comment_provider;
	}


	public function getFollowers($user_id){
		$followers = FollowerRelation::getFollowers($user_id);

		$followers_provider = new \yii\data\ArrayDataProvider([
			'allModels' => $followers,
			'pagination' => [
				'pageSize' => 10,
			]
		]);

		return $followers_provider;
	}


	public function getFollowees($user_id){
		$followees = FollowerRelation::getFollowees($user_id);

		$followees_provider = new \yii\data\ArrayDataProvider([
			'allModels' => $followees,
			'pagination' => [
				'pageSize' => 10,
			]
		]);

		return $followees_provider;
	}

	public function actionUpload(){
	//	Yii::$app->end("s");
		$model = new UploadProfilePicForm();
		if($model->load(Yii::$app->request->post()) && $model->validate()) {

			$model->imageFile = UploadedFile::getInstance($model, 'imageFile');

			if ($model->upload()) {
				// file is uploaded successfully
				return $this->redirect(Yii::$app->request->baseUrl . '/user/' . User::getUsername(Yii::$app->user->getId()));
			}
			else{
				return $this->redirect(Yii::$app->request->baseUrl . '/site/error');
			}
		}

		return $this->redirect(Yii::$app->request->baseUrl . '/site/error');

	}




}

