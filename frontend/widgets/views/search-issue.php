<?php
/** @var $all_issues array*/
/** @var $edit_user_issue_form frontend\models\EditUserIssueForm */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\libraries\ImageUtility;
?>

<div class="container-fluid">

    <div class="col-xs-12">
        <h3 align="left">Follow at least 5 issue</h3>
    </div>
    <div class="col-xs-12" id="search-issue-search">
        <?= Html::textInput('issue[]', null, ['id' => 'search-issue-search-input', 'class' => 'form-control', 
            'placeholder' => 'Search for issues', 'align' => 'left'
            ]) ?>
        </div>

        <div class="col-xs-12" id="search-issue-searched-list">
            <?= Html::img(ImageUtility::getResourceUrl(ImageUtility::LOADING_GIF), 
                ['id' => 'search-issue-searched-list-loading', 
                'style' => 'display:none']) ?>
                <div id="search-issue-searched-list-section">
                </div>
            </div>

            <div class="col-xs-12" id="search-issue-selector">
                <!-- Notes for development -->
                <!--
    
                    Jadi kita buat input type checkbox lihat issue difollow atau tidak
                    Input itu dikasih id supaya label bisa sync sama input checkbox tadi
                    
                -->
                <input class="select-issue-checkbox" type="checkbox" id="01" />
                <input class="select-issue-checkbox" type="checkbox" id="02" />
                <input class="select-issue-checkbox" type="checkbox" id="03" />

                <label for="01" class="search-issue not-selected">Education</label>
                <label for="02" class="search-issue not-selected">Politic</label>
                <label for="03" class="search-issue not-selected">News</label>
            </div>

            <div class="col-xs-12" id="search-issue-bottom">
                <?php $form = ActiveForm::begin(['action' => ['site/user-issue'], 'id' => 'search-issue-form', 'method' => 'post']) ?>
                <?= $form->field($edit_user_issue_form, 'issue_list')->hiddenInput() ?>
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                <?php ActiveForm::end() ?>
            </div>
        </div>  
