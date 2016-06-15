<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
	public function actionInit()
	{
		$auth = Yii::$app->authManager;

		// THREAD PERMISSIONS
		$viewAllThread = $auth->createPermission('view_all_thread');
		$viewAllThread->description = 'View All Thread';
		$auth->add($viewAllThread);

		$createThread = $auth->createPermission('create_thread');
		$createThread->description = 'Create Thread';
		$auth->add($createThread);

		$editThread = $auth->createPermission('edit_thread');
		$editThread->description = 'Edit Thread';
		$auth->add($editThread);

		$banThread = $auth->createPermission('ban_thread');
		$banThread->description = 'Ban Thread';
		$auth->add($banThread);

		// THREAD COMMENT PERMISSIONS
		$viewAllThreadComment = $auth->createPermission('view_all_thread_comment');
		$viewAllThreadComment->description = 'View All Thread Comment';
		$auth->add($viewAllThreadComment);

		$editThreadComment = $auth->createPermission('edit_thread_comment');
		$editThreadComment->description = 'Edit Thread Comment';
		$auth->add($editThreadComment);

		$banThreadComment = $auth->createPermission('ban_thread_comment');
		$banThreadComment->description = 'Ban Thread Comment';
		$auth->add($banThreadComment);

		// CHILD COMMENT PERMISSIONS
		$viewAllChildComment = $auth->createPermission('view_all_child_comment');
		$viewAllChildComment->description = 'View All Child Comment';
		$auth->add($viewAllChildComment);

		$editChildComment = $auth->createPermission('edit_child_comment');
		$editChildComment->description = 'Edit Child Comment';
		$auth->add($editChildComment);

		$banChildComment = $auth->createPermission('ban_child_comment');
		$banChildComment->description = 'Ban Child Comment';
		$auth->add($banChildComment);

		// ISSUE PERMISSIONS
		$viewAllIssue = $auth->createPermission('view_all_issue');
		$viewAllIssue->description = 'View All Issue';
		$auth->add($viewAllIssue);

		$createIssue = $auth->createPermission('create_issue');
		$createIssue->description = 'Create Issue';
		$auth->add($createIssue);

		$editIssue = $auth->createPermission('edit_issue');
		$editIssue->description = 'Edit Issue';
		$auth->add($editIssue);

		$banIssue = $auth->createPermission('ban_issue');
		$banIssue->description = 'Ban Issue';
		$auth->add($banIssue);

		$requestIssue = $auth->createPermission('request_issue');
		$requestIssue->description = 'Request Issue';
		$auth->add($requestIssue);

		// USER PERMISSIONS
		$viewAllUser = $auth->createPermission('view_all_user');
		$viewAllUser->description = 'View All User';
		$auth->add($viewAllUser);

		$accessUser = $auth->createPermission('access_user');
		$accessUser->description = 'Access User';
		$auth->add($accessUser);

		$promoteUser = $auth->createPermission('promote_user');
		$promoteUser->description = 'Promote User';
		$auth->add($promoteUser);

		// add 'admin' role
		$admin = $auth->createRole('admin');
		$auth->add($admin);

		// add 'admin' permission
		$auth->addChild($admin, $viewAllThread);
		$auth->addChild($admin, $createThread);
		$auth->addChild($admin, $editThread);
		$auth->addChild($admin, $banThread);

		$auth->addChild($admin, $viewAllThreadComment);
		$auth->addChild($admin, $editThreadComment);
		$auth->addChild($admin, $banThreadComment);

		$auth->addChild($admin, $viewAllChildComment);
		$auth->addChild($admin, $editChildComment);
		$auth->addChild($admin, $banChildComment);

		$auth->addChild($admin, $viewAllIssue);
		$auth->addChild($admin, $createIssue);
		$auth->addChild($admin, $editIssue);
		$auth->addChild($admin, $banIssue);
		$auth->addChild($admin, $requestIssue);

		$auth->addChild($admin, $viewAllUser);
		$auth->addChild($admin, $accessUser);
		$auth->addChild($admin, $promoteUser);

		// assign 'admin' role to user_id
		$auth->assign($admin, 72);
	}
}

?>
