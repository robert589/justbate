s<?php
/** @var $issue_followed_by_user array*/
/** @var $edit_user_issue_form frontend\models\EditUserIssueForm */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\libraries\ImageUtility;
?>
<div class="container-fluid">
    <div class="col-xs-12">
        <h3 align="left">Followed issue currently </h3>
    </div>
    <div class="search-issue-followed-by-user col-xs-12" align="left">
        <?php foreach($issue_followed_by_user as $item) { ?>
            <label class="search-issue"> <?= $item ?> </label>
        <?php } ?>
    </div>       
    <div class="col-xs-12">
        <h3 align="left">Follow at least 5 issue</h3>
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
        
    <div class="col-xs-12" class="search-issue-selector" id="search-issue-searched-list">
            
    </div>
    <div class="col-xs-12" id="search-issue-bottom">
        <?php $form = ActiveForm::begin(['action' => ['site/user-issue'], 'id' => 'search-issue-form', 'method' => 'post']) ?>
            <?= $form->field($edit_user_issue_form, 'issue_list')->hiddenInput() ?>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>  
