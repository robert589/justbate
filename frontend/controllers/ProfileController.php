<?php
namespace frontend\controllers;

use frontend\models\EditProfileForm;
use frontend\models\UploadProfilePicForm;
use frontend\models\FollowerForm;

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


	public function actionBusiness(){
	}
	
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

				return $this->render('index', [
					'user' => $user_info,
					'num_followers' => $num_follower,
					'num_following' => $num_following,
					'num_followings' => $num_following,
					'followees' => $followees,
					'followers' => $followers
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



	 public function actionUpload()
	{
		if(Yii::$app->request->isPost){
			$model = new UploadProfilePicForm();

			if($model->load(Yii::$app->request->post()) && $model->validate()) {

				$model->imageFile = UploadedFile::getInstance($model, 'imageFile');

				if ($model->upload()) {
					// file is uploaded successfully
					return $this->redirect(Yii::getAlias('@base-url') . '/profile/index?username=' . User::getUsername(Yii::$app->user->getId()));
				}
			}

			return $this->render('upload', ['model' => $model]);
		}
		else{

		}

	}

	// Added by Peter
	public static function actionFollow() {
		$follower_form = new FollowerForm();

		if($follower_form->load(Yii::$app->request->post()) && $follower_form->validate()) {
			
		}
	}





	private function getRecentActivity($username){
		$user_comment_recent_activity = Comment::getRecentCommentActivity($username);
		$user_comment_likes_recent_activity = CommentLikes::getRecentCommentLikes($username);
		$user_thread_activity = Thread::getRecentActivityCreateThread($username);

		return $this->mergeAllActivities($user_comment_recent_activity, $user_comment_likes_recent_activity, $user_thread_activity);
	}

	/**
	 * @param $username username of this user
	 * @return \yii\data\ArrayDataProvider
	 */
	private function getRecentTagsAsProvider($username){

		// build an ActiveDataProvider with an empty query and a pagination with 35 items for page
		$recent_tag_provider = new \yii\data\ArrayDataProvider([
			'allModels' => TagInThread::getRecentTags($username),
			'pagination' => [
				'pageSize' => 10,
			],
		]);

		return $recent_tag_provider;
	}


	/**
	 * Merge all activities of the user in comment, comment_likes, thread
	 * @param $comment_activities
	 * @param $comment_likes_activities
	 * @param $thread_activities
	 * @return array
	 */
	private function mergeAllActivities($comment_activities, $comment_likes_activities, $thread_activities){
		$recent_activity = array();

		$ca_counter = 0;
		$cl_counter = 0;
		$ca_size = count($comment_activities);
		$cl_size = count($comment_likes_activities);

		foreach($comment_activities as $comment_activity){
			foreach($comment_likes_activities as $comment_likes_activity){
				//If this comment activity is newer then this comment_likes_activity
				if($comment_activity['date_created'] > $comment_likes_activity['date_created']){
					$recent_activity[] = $this->getCommentWords($comment_activity);
					$ca_counter++;
				}
				//If not
				else{
					$cl_counter++;
					break;
				}
				//if the recent activity array has surpassed ten items
				if(count($recent_activity) >= 10){
					 break;
				}
			}
			//if the recent activity array has surpassed ten items
			if(count($recent_activity) >= 10){
				 break;
			}
		}
		//if still less than 10
		if(count($recent_activity) <= 10){
			if($cl_counter >= $cl_size ){
			  //  $recent_activity[] = $comment_likes_activities[];
			}

			if($ca_counter >= $ca_size){

			}


		}



		return $recent_activity;

	}

	private function getCommentWords($comment_activity){

		//Then comment activity needs to be put first
		//if this comment activity has not parent id (it means the comment ctivity is directly to the thread)
		if($comment_activity['parent_id'] == null){
			$thread_title = $comment_activity['title'];
			$full_name = $comment_activity['first_name'] . ' '.  $comment_activity['last_name'];
			$full_name_link = Yii::getAlias('@base-url') . "/profile/index?username=" . $comment_activity['username'];
			$thread_link = Yii::getAlias('@base-url'). "/thread/index?id=" . $comment_activity['thread_id'];
			$word = "You commented on thread \" <a href='". $thread_link ."'> $thread_title </a> \"
												by <a href='". $full_name_link ."'> $full_name </a> ";

		}
		//if this comment activity has parent id, this means this is a child comment
		else{
			$full_name = $comment_activity['parent_first_name'] . ' '. $comment_activity['parent_last_name'];
			$thread_title = $comment_activity['title'];
			$word = "You commented on $full_name's comment on thread \" $thread_title \" ";
		}

		return $word;
	}

	private function getCommentLikeWords($comment_likes_activity){

	}

}

