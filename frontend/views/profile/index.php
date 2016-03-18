<?php

/* @var $this yii\web\View */
/** @var $user \yii\base\Object */
/** @var $type string */
/** @var $model_provider \yii\data\ArrayDataProvider */
/** @var $num_followings integer */
/** @var $num_followers integer */

use yii\helpers\Html;
use yii\widgets\ListView;
use frontend\controllers\ProfileController;
use yii\bootstrap\Modal;
use common\models\User;

//Set title for the page
$this->title = $user->first_name . ' ' . $user->last_name;

//link variable
$thread_starter_link =  Yii::$app->request->baseUrl . '/user/' . $user->username . '/starters';
$comment_link =  Yii::$app->request->baseUrl . '/user/' . $user->username . '/comments';
$follower_link =  Yii::$app->request->baseUrl . '/user/' . $user->username . '/followers';
$followee_link =  Yii::$app->request->baseUrl . '/user/' . $user->username . '/followees';

?>

<!-- Edit Profile Modal-->
<?php
	Modal::begin([
		'id' => 'editModal',
		'size' => 'modal-lg'
	]);
		$editProfileModel = new \frontend\models\EditProfileForm();
		$editUser = new User();
		// $editUser->id = \Yii::$app->user->identity->getId();
		$user_data = $editUser->getUser();
		// pass data
		$editProfileModel->occupation = $user_data['occupation'];
		$editProfileModel->birthday = $user_data['birthday'];
		$editProfileModel->first_name = $user_data['first_name'];
		$editProfileModel->last_name = $user_data['last_name'];
		echo $this->render('edit', ['model' => $editProfileModel]);
    Modal::end();
?>


<!-- Upload photo modal -->
<?php
	Modal::begin([
		'id' => 'uploadProfilePicModal',
		'size' => 'modal-lg'
	]);
	$uploadFormModel = new \frontend\models\UploadProfilePicForm();
	echo $this->render('_upload_photo_modal', ['model' => $uploadFormModel]);
	Modal::end();
?>
<!-- Page Content -->
<!-- <div class="container" style="margin-left: 0; margin-right: 0;"> -->
<div class="container">
	<div class="col-md-8" style="background-color: white;">
		<div class="row">
			<br>
			<div class="col-xs-6 col-md-3">
				<img class="img-rounded" src="<?= Yii::$app->request->baseUrl . '/frontend/web/photos/' . $user->photo_path ?>"
					 alt="Profile Picture"
					 style="width:148px;height:148px;"
					 id="avatar">
				<?= Html::button('Upload Photo', ['class' => 'btn btn-primary', 'id' => 'upload-image']) ?>
			</div>
			<div class="col-xs-12 col-md-4">
				<div id="displayName">
					<?= $user->first_name ?> <?= $user->last_name ?>
					<div align="right">
						<?= $this->render('_index_follow_button', ['is_following' => $is_following, 'followee_id' => $user['id']]) ?>
					</div>
				</div>
				<hr>
				<table id="bio-table" class="table table-responsive">
					<tr><td>Birthday</td><td><?= $user->birthday ?></td></tr>
					<tr><td>Occupation</td><td><?= $user->occupation ?></td></tr>
				</table>
			</div>
		</div>
		<hr>
		<div class="row" style="min-height: 350px">
			<div class="col-md-3">
				<ul class="sidebar-nav" style="width: 150px;border-right-style:solid; border-right-width: 1px">
					<div style="margin-left: 40px">
						<label><u>Feeds</u></label>
					</div>
					<li>
						<a href="<?= $comment_link ?>">Comments</a>
					</li>
					<li>
						<a href="<?= $thread_starter_link ?>">Thread Starters</a>
					</li>
					<li>
						<a href="<?= $follower_link?>">Followers <span class="badge"><?= $num_followers ?></span></a>
					</li>
					<li>
						<a href="<?= $followee_link ?>">Following <span class="badge"><?= $num_followings ?></span></a>
					</li>
				</ul>
			</div>
			<div class=" col-xs-12 col-md-6" style="float: left;">
				<?php if($type == ProfileController::THREAD_STARTERS){ ?>
					<h3>Thread Starters</h3>
					<hr>
					<?= ListView::widget([
						'id' => 'thread_starter_list_view',
						'dataProvider' => $model_provider,
						'pager' => ['class' => \kop\y2sp\ScrollPager::className()],
						'summary' => false,
						'itemOptions' => ['class' => 'item'],
						'layout' => "{summary}\n{items}\n{pager}",
						'itemView' => function ($model, $key, $index, $widget) {
							return $this->render('_list_starters',['model' => $model]);
						}
					])
					?>
				<?php }else if($type == ProfileController::COMMENTS){ ?>
					<h3>Comments</h3>
					<hr>
					<?= ListView::widget([
						'id' => 'thread_starter_list_view',
						'dataProvider' => $model_provider,
						'pager' => ['class' => \kop\y2sp\ScrollPager::className()],
						'summary' => false,
						'itemOptions' => ['class' => 'item'],
						'layout' => "{summary}\n{items}\n{pager}",
						'itemView' => function ($model, $key, $index, $widget) {
							return $this->render('_list_comments',['model' => $model]);
						}
					])
					?>

				<?php }else if($type == ProfileController::FOLLOWERS){ ?>
					<h3>Followers</h3>
					<hr>
					<?= ListView::widget([
						'id' => 'thread_starter_list_view',
						'dataProvider' => $model_provider,
						'pager' => ['class' => \kop\y2sp\ScrollPager::className()],
						'summary' => false,
						'itemOptions' => ['class' => 'item'],
						'layout' => "{summary}\n{items}\n{pager}",
						'itemView' => function ($model, $key, $index, $widget) {
							return $this->render('_list_follower',['model' => $model]);
						}
					])
					?>

				<?php } else if($type == ProfileController::FOLLOWEES ){ ?>
					<h3>Followees</h3>
					<hr>
					<?= ListView::widget([
						'id' => 'thread_starter_list_view',
						'dataProvider' => $model_provider,
						'pager' => ['class' => \kop\y2sp\ScrollPager::className()],
						'summary' => false,
						'itemOptions' => ['class' => 'item'],
						'layout' => "{summary}\n{items}\n{pager}",
						'itemView' => function ($model, $key, $index, $widget) {
							return $this->render('_list_follower',['model' => $model]);
						}
					])
					?>

				<?php } ?>
			</div>
		</div>
	</div>
</div>
