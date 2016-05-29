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
    use yii\helpers\Html;
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
            'heading' => 'Followed issue' ,
            'items' => $issue_list,
        ]) ?>
    </div><!-- div.col-xs-12 -->

    <div id="home-add-issue-button-div" class="col-xs-12" align="center" style="margin-bottom: 5px">
        <?= Html::button('Add more issue', ['class' => 'btn btn-default', 'id' => 'home-add-issue-button']) ?>
    </div>

    <div id="home-add-issue-form-div" class="col-xs-12" align="center" style="display: none;margin-bottom: 10px">

        <label>Select issue</label>

<?php $form = ActiveForm::begin(['action' => ['site/add-issue'],
    'method' => 'post',
    'id' => 'add-issue-form',
    'options' => ['data-pjax' => '#sidenav-issue']])
?>

        <?= $form->field($add_issue_form, 'issue_name')->widget(Select2::className(), [
            'class'  => 'form-input',
            'theme' => Select2::THEME_KRAJEE,
            'options' => ['placeholder' => 'Search'],
            'pluginEvents' => [
                "select2:select" => "function(){
                                                }"
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 1,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => \yii\helpers\Url::to(['site/search-issue']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(issue) { return issue.text; }'),
                'templateSelection' => new JsExpression('function (issue) { return issue.text; }'),
            ],

        ]) ?>

        <?= $form->field($add_issue_form, 'user_id')->hiddenInput(['value' => \Yii::$app->user->getId()]) ?>

        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end() ?>

    </div>

<?php
    Pjax::end();
?>