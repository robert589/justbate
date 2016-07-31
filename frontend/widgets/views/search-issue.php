<?php
/** @var $issue_followed_by_user array*/
/** @var $edit_user_issue_form frontend\models\EditUserIssueForm */
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use common\libraries\ImageUtility;
?>
<div class="container-fluid">
    <div class="col-xs-12">
        <h3 align="left" style="color:red">Followed issue</h3>
    </div>
    <div class="search-issue-followed-by-user col-xs-12" align="left">
        <?php foreach($issue_followed_by_user as $item) { ?>
            <label class="search-issue"> <?= $item ?> </label>
            <?php } ?>
    </div>
    <div class="col-xs-12" style="margin-top:16px">
        <label align="left">Search other issues</label>
    </div>
    <div class="col-xs-12" id="search-issue-search">
        <?= Html::textInput('issue[]', null,
         [    'id' => 'search-issue-search-input',
         'class' => 'form-control',
         'placeholder' => 'Search for issues',
         'align' => 'left']) ?>
     </div>

    <?= Html::img(ImageUtility::getResourceUrl(ImageUtility::LOADING_GIF),
       ['id' => 'search-issue-searched-list-loading',
       'style' => 'display:none', 'align' => 'center']) ?>

    <div class="col-xs-12" class="search-issue-selector" id="search-issue-searched-list" style="margin-top:8px">

    </div>
    
    <div class="col-xs-12" align="center">
        <label id="search-issue-error-label"></label>
    </div>
    <?php Pjax::begin(['id' => 'search-issue-pjax']); ?>
    <div class="col-xs-12" id="search-issue-bottom">
        <?php $form = ActiveForm::begin(['action' => ['site/edit-user-issue'], 
            'id' => 'search-issue-form', 'method' => 'post', 'enableClientValidation' => true]) ?>
            <?= Html::button('Save', ['class' => 'btn btn-primary', 'id' => 'search-issue-save-btn']) ?>
        <?php ActiveForm::end() ?>
    </div>
    
    <?php Pjax::end(); ?>
</div>
