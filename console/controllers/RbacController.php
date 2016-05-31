<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
	public function actionInit()
	{
		$auth = Yii::$app->authManager;

		// add 'ban_comment' permission
		$banComment = $auth->createPermission('ban_comment');
		$banComment->description = 'Ban Comment';
		$auth->add($banComment);

		// add 'ban_thread' permission
		$banThread = $auth->createPermission('ban_thread');
		$banThread->description = 'Ban Thread';
		$auth->add($banThread);

		// add 'edit_comment' permission
		$editComment = $auth->createPermission('edit_comment');
		$editComment->description = 'Edit Comment';
		$auth->add($editComment);

		// add 'edit_thread' permission
		$editThread = $auth->createPermission('edit_thread');
		$editThread->description = 'Edit Thread';
		$auth->add($editThread);

		// add 'admin' role
		$admin = $auth->createRole('admin');
		$auth->add($admin);

		// add 'admin' permission
		$auth->addChild($admin, $banComment);
		$auth->addChild($admin, $banThread);
		$auth->addChild($admin, $editComment);
		$auth->addChild($admin, $editThread);

		// assign 'admin' role to user_id
		$auth->assign($admin, 72);
	}
}

?>
