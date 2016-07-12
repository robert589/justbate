<?php
namespace frontend\widgets;

use frontend\models\EditUserIssueForm;
use frontend\widgets\CommentInputAnonymousAsset;
use yii\base\Widget;
use yii\helpers\Html;

class SearchIssue extends Widget
{
    /** @var  $array  array  */
    public $all_issues;


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
            'edit_user_issue_form' => new EditUserIssueForm()]);
    }
}