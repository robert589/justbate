<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends controllers
{
	public function actionInit()
	{
		$auth = Yii::$app->authManager;

		// add 'banCommentForm' permission
		$banCommentForm = $auth->createPermission('banCommentForm');
		$banCommentForm->description = 'Ban Comment Form';
		$auth->add($banCommentForm);

		// add 'banIssueForm' permission
		$banIssueForm = $auth->createPermission('banIssueForm');
		$banIssueForm->description = 'Ban Issue Form';
		$auth->add($banIssueForm);

		// add 'banThreadForm' permission
		$banThreadForm = $auth->createPermission('banThreadForm');
		$banThreadForm->description = 'Ban Thread Form';
		$auth->add($banThreadForm);

		// add 'createIssueForm' permission
		$createIssueForm = $auth->createPermission('createIssueForm');
		$createIssueForm->description = 'Create Issue Form';
		$auth->add($createIssueForm);

		// add 'deleteIssueForm' permission
		$deleteIssueForm = $auth->createPermission('deleteIssueForm');
		$deleteIssueForm->description = 'Delete Issue Form';
		$auth->add($deleteIssueForm);

		// add 'editChoiceForm' permission
		$editChoiceForm = $auth->createPermission('editChoiceForm');
		$editChoiceForm->description = 'Edit Choice Form';
		$auth->add($editChoiceForm);

		// add 'editChoiceThreadCommentForm' permission
		$editChoiceThreadCommentForm = $auth->createPermission('editChoiceThreadCommentForm');
		$editChoiceThreadCommentForm->description = 'Edit Choice Thread Comment Form';
		$auth->add($editChoiceThreadCommentForm);

		// add 'editCommentForm' permission
		$editCommentForm = $auth->createPermission('editCommentForm');
		$editCommentForm->description = 'Edit Comment Form';
		$auth->add($editCommentForm);

		// add 'editIssueForm' permission
		$editIssueForm = $auth->createPermission('editIssueForm');
		$editIssueForm->description = 'Edit Issue Form';
		$auth->add($editIssueForm);

		// add 'editThreadForm' permission
		$editThreadForm = $auth->createPermission('editThreadForm');
		$editThreadForm->description = 'Edit Thread Form';
		$auth->add($editThreadForm);

		// add 'admin' role
		$admin = $auth->createRole('admin');
		$auth->add($admin);

		// add 'admin' permission
		$auth->addChild($admin, $banCommentForm);
		$auth->addChild($admin, $banIssueForm);
		$auth->addChild($admin, $banThreadForm);
		$auth->addChild($admin, $createIssueForm);
		$auth->addChild($admin, $deleteIssueForm);
		$auth->addChild($admin, $editChoiceForm);
		$auth->addChild($admin, $editChoiceThreadCommentForm);
		$auth->addChild($admin, $editCommentForm);
		$auth->addChild($admin, $editIssueForm);
		$auth->addChild($admin, $editThreadForm);

		// assign 'admin' role to user_id
		$auth->assign($admin, 1);
	}
}

?>
