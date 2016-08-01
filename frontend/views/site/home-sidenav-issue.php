<?php
/**
 * The form structure will be similar with the follow button
 */

/** @var $issue_list array */
/** @var $add_issue_form \frontend\models\UserFollowIssueForm */
use kartik\widgets\Select2;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use kartik\sidenav\SideNav;
use yii\widgets\ActiveForm;

$select2_content =
    Select2::widget([
        'name' => 'add-new-issue-select-2',
        'id' => 'add-new-issue-select-2',
        'theme' => Select2::THEME_KRAJEE,
        'options' => ['placeholder' => 'Search Issue'],
        'pluginEvents' => [
            'select2:select' => 'function(){
                        $("#add-issue-form-issue-name").val($(this).val());
                        $("#add-issue-form").submit();
                    }'
        ],
        'pluginOptions' => [
            'multiple' => true,
            'maximumSelectionSize' => 1,
            'allowClear' => true,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
                'url' => \yii\helpers\Url::to(['site/search-issue', 'except-own' => 'true']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(issue) { return issue.text; }'),
            'templateSelection' => new JsExpression('function (issue) { return issue.text; }'),
        ]]);

?>

<?php
Pjax::begin([
    'id' => 'sidenav-issue-pjax',
    'timeout' => false,
    'enablePushState' => false,
    'clientOptions' => [
        'container' => '#sidenav-issue'
    ]
]);
?>
    <div class="col-xs-12">
        <?= SideNav::widget([
            'type' => SideNav::TYPE_DEFAULT,
            'heading' => 'Feeds ' .
                        '<a class="btn" style="float:right;padding:0px"
                            id="home-issue-edit-popover" data-container="#home-add-issue-popover-conte">
                            <span class="glyphicon glyphicon-pencil"></ span>
                         </a>' ,
            'items' => $issue_list,
        ]); ?>
        <div id="home-add-issue-popover-content" style="display: none;margin-bottom:8px">

            <?= Select2::widget([
                'id' => 'add-new-issue-select-2',
                'name' => 'add-new-issue-select-2',
                'theme' => Select2::THEME_KRAJEE,
                'options' => ['placeholder' => 'Search Issue'],
                'pluginEvents' => [
                    'select2:select' => 'function(){
                        $("#add-issue-form-issue-name").val($(this).val());
                        $("#add-issue-form").submit();
                    }'
                ],
                'pluginOptions' => [
                    'multiple' => true,
                    'maximumSelectionSize' => 1,
                    'allowClear' => true,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                    ],
                    'ajax' => [
                        'url' => \yii\helpers\Url::to(['site/search-issue', 'except-own' => 'true']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(issue) { return issue.text; }'),
                    'templateSelection' => new JsExpression('function (issue) { return issue.text; }'),
                ]]); ?>

        </div>
    </div>

    <?php $form = ActiveForm::begin(['action' => ['site/add-issue'],
            'method' => 'post',
            'id' => 'add-issue-form',
            'options' => ['data-pjax' => '#sidenav-issue']])?>
        <?= $form->field($add_issue_form, 'user_id')->hiddenInput(['value' => \Yii::$app->user->getId()]) ?>
        <?= $form->field($add_issue_form, 'issue_name')->hiddenInput(['id' => 'add-issue-form-issue-name']) ?>
    <?php ActiveForm::end() ?>

<?php Pjax::end(); ?>

