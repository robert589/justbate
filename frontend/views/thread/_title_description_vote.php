<?php
   use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use yii\widgets\Pjax;
    use yii\helpers\HtmlPurifier;
    use common\components\Constant;
    use kartik\widgets\Select2;
    use yii\web\JsExpression;
    use yii\redactor\widgets\Redactor;
/** @var $thread \common\entity\ThreadEntity */
/** @var $submit_vote_form \frontend\models\SubmitThreadVoteForm */
/** @var $edit_thread_form \frontend\models\EditThreadForm */

if(!isset($vote_tab_active)){
    $vote_tab_active = true;
}
$current_user_choice = $thread->getCurrentUserChoice();
$choices_in_thread = $thread->getChoices();
$description = $thread->getDescription();
$title = $thread->getTitle();
$thread_id = $thread->getThreadId();
$thread_issues  = $thread->getThreadIssues();
$edit_thread_form->issues = $thread_issues;
$edit_thread_form->title = $title;
$edit_thread_form->description = HtmlPurifier::process($description, Constant::DefaultPurifierConfig());

Pjax::begin([
    'id' => 'edit_thread_pjax',
    'timeout' => false,
    'enablePushState' => false,
    'clientOptions'=>[
        'container' => '#edit_thread',
    ]
    ]
);?>
    <div id="shown_title_description_part">
        <div id="thread-issue-wrapper" class="col-xs-12">
            <?= $this->render('_thread_issues', [ 'thread' => $thread]) ?>
        </div>
        <div class="col-xs-12 thread-title">
            <?= Html::encode($title) ?>
        </div>
        <div id='post-description' class="col-xs-12" align="center">
            <?= HtmlPurifier::process($description, Constant::DefaultPurifierConfig()) ?>
        </div>
    </div>
    <div id="edit_title_description_part" style="display: none">
        <?php $form = ActiveForm::begin([
                'action' => ['thread/edit-thread'],
                'method' => 'post',
                'options' => ['data-pjax' => '#edit_thread']
            ])
        ?>
            <?= $form->field($edit_thread_form, 'thread_id')->hiddenInput(['value' => $thread_id]) ?>
            <div class="row">
                <!-- Topic Name -->
                <?= $form->field($edit_thread_form, 'issues')->widget(Select2::classname(), [

                    'maintainOrder' => true,
                    'options' => ['placeholder' => 'Select Keywords ...', 'multiple' => true],
                    'pluginOptions' => [
                        'tags' => true,
                        'ajax' => [
                            'url' => \yii\helpers\Url::to(['site/search-issue']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(topic_name) { return topic_name.text; }'),
                        'templateSelection' => new JsExpression('function (topic_name) { return topic_name.text; }'),
                    ]
                ])->label(false) ?>
            </div>

            <div class="row">
                <?= $form->field($edit_thread_form, 'title')->textInput(['placeholder' => 'Title..', 'class' => 'form-control']) ?>
            </div>

            <div class="row">
                <?= $form->field($edit_thread_form, 'description')->widget(Redactor::className(), [
                    'clientOptions' => [
                        'plugins' => Constant::defaultPluginRedactorConfig(),
                        'buttons' => Constant::defaultButtonRedactorConfig(),
                        'imageUpload' => \yii\helpers\Url::to(['/redactor/upload/image']),
                    ],
                ]) ?>
            </div>

            <div class="row" align="right">
                <?= Html::button('Cancel', ['class' => 'btn btn-danger', 'id' => 'cancel_edit_thread_button']) ?>
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
            </div>

        <?php  ActiveForm::end(); ?>
    </div>
<?php Pjax::end(); ?>

