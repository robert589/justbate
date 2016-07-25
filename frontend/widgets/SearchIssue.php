<?php
namespace frontend\widgets;

use frontend\models\EditUserIssueForm;
use yii\base\Widget;

class SearchIssue extends Widget
{
    /** @var  $array  array  */
    public $all_issues;
    
    public $issue_followed_by_user;

    public function init()
    {
        parent::init();

        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        SearchIssueAsset::register($view);

    }

    public function run()
    {
        return $this->render('search-issue',
            ['all_issues' => $this->all_issues,
                'issue_followed_by_user' => $this->issue_followed_by_user,
            'edit_user_issue_form' => new EditUserIssueForm()]);
    }
}