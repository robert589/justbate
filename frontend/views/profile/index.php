<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ListView;
use kartik\select2\Select2;
use kartik\tabs\TabsX;
use yii\data\ArrayDataProvider;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use common\models\User;

//Set title for the page
$this->title = $user->first_name . ' ' . $user->last_name;
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

<?php
$item = [
	[
		'label' => 'Main Activity',
		'content' => '',
		'active' => false,
	],

	[
		'label' => 'Following',
		'content' => ListView::widget([
			'dataProvider' => $followings_provider,
			'summary' => false,
			'itemOptions' => ['class' => 'item'],
			'layout' => "{summary}\n{items}\n{pager}",
			'itemView' => function ($model, $key, $index, $widget) {
				return $this->render('_list_follower', ['model' => $model]);
			}
			// $this->render('_list_following', ['first-name' => $model[first_name], 'last-name' => $model[last_name]])
		]),
		'active' => true,
	],

	[
		'label' => 'Follower',
		'content' => ListView::widget([
			'dataProvider' => $followers_provider,
			'summary' => false,
			'itemOptions' => ['class' => 'item'],
			'layout' => "{summary}\n{items}\n{pager}",
			'itemView' => function ($model, $key, $index, $widget) {
				return $this->render('_list_follower', ['model' => $model]);
			}
			// $this->render('_list_following', ['model' => $model, 'first-name' => $model[first_name], 'last-name' => $model[last_name]])
		]),
		'active' => false,
	]
];
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
	<div class="row">

		<div class="col-xs-6 col-md-2">
			<img class="img-rounded" src="<?= Yii::getAlias('@image_dir') . '/' . $user->photo_path ?>" alt="Profile Picture" style="width:148px;height:148px;" id="avatar">
			<?= Html::button('Upload Photo', ['onclick' => 'beginProfilePicModal()', 'class' => 'btn btn-primary', 'id' => 'upload-image']) ?>
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

	<br>
	<div class="container">
		<div class=" col-xs-12 col-md-6" style="float: left;">
				<?=
				TabsX::widget([
					'items'=>$item,
					'position'=>TabsX::POS_ABOVE,
					'encodeLabels'=>false
				])
				?>
			</div>
		</div>
	</div>

<div class="col-xs-12">
	<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/frontend/web/js/profile-index.js'); ?>
</div>
