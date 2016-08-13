<?php
   use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use yii\widgets\Pjax;
    use yii\helpers\HtmlPurifier;
    use common\components\Constant;
    use kartik\widgets\Select2;
    use yii\web\JsExpression;
    use yii\redactor\widgets\Redactor;
    use common\widgets\SimpleSeeMore;
/** @var $thread \frontend\vo\ThreadVo */
/** @var $submit_vote_form \frontend\models\SubmitThreadVoteForm */
/** @var $edit_thread_form \frontend\models\EditThreadForm */

if(!isset($vote_tab_active)){
    $vote_tab_active = true;
}
$current_user_choice = $thread->getCurrentUserVote();
$choices_in_thread = $thread->getChoices();
$description = $thread->getDescription();
$title = $thread->getTitle();
$thread_id = $thread->getThreadId();
$thread_issues  = $thread->getThreadIssues();
$thread_link = $thread->getThreadLink();
$edit_thread_form->issues = $thread_issues;
$edit_thread_form->title = $title;
$edit_thread_form->description = HtmlPurifier::process($description, Constant::DefaultPurifierConfig());
?>
    <div id="thread-section-view-<?= $thread_id ?>">
        <div id="thread-issue">
            <?= $this->render('thread-issues', [ 'thread' => $thread]) ?>
        </div>
            
        <div class="thread-view">

            <div class="thread-link">
                <?php if(isset($site)) { ?> 
                    <?= Html::a($title, $thread_link) ?>
                <?php } else { ?>
                    <?= Html::encode($title) ?>
                <?php } ?>
            </div>
            <div class='thread-description' align="left">
                <?= SimpleSeeMore::widget(['id' => 'thread-section-description-' . $thread_id, 
                    'active' => 'true', 'text' => $description]) ?>
            </div>
        </div>
    </div>

    <div id="thread-section-edit-<?= $thread_id ?>" class="thread-section-edit" style="display:none" >
        <?php $form = ActiveForm::begin([ 
                'action' => ['thread/edit-thread'],
                'method' => 'post',
                'options' => ['data-pjax' => '#edit_thread']
            ])
        ?>
            <?= $form->field($edit_thread_form, 'thread_id')->hiddenInput(['value' => $thread_id]) ?>
            <div class="thread-section-edit-issues">
                <!-- Topic Name -->
                <?= $form->field($edit_thread_form, 'issues')->widget(Select2::classname(), [
                    'maintainOrder' => true,
                    'options' => ['placeholder' => 'Select Keywords ...', 'multiple' => true,
                        'id' => 'thread-section-edit-issues-widget-' . $thread_id],
                    'pluginOptions' => [
                        'tags' => true,
                        'ajax' => [
                            'url' => \yii\helpers\Url::to(['site/search-issue']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {query:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(topic_name) { return topic_name.text; }'),
                        'templateSelection' => new JsExpression('function (topic_name) { return topic_name.text; }'),
                    ]
                ])->label(false) ?>
            </div>
            <div class="thread-section-edit-title">
                <?= $form->field($edit_thread_form, 'title')->textInput(['placeholder' => 'Title..', 'class' => 'form-control']) ?>
            </div>
            <div class="thread-section-edit-description">
                <?= $form->field($edit_thread_form, 'description')->widget(Redactor::className(), [
                    'options' => [
                        'id' => 'thread-section-edit-description-' . $thread_id
                    ],
                    'clientOptions' => [
                        'plugins' => Constant::defaultPluginRedactorConfig(),
                        'buttons' => Constant::defaultButtonRedactorConfig(),
                        'imageUpload' => \yii\helpers\Url::to(['/redactor/upload/image']),
                    ],
                ]) ?>
            </div>

            <div class="thread-section-edit-button" align="right">
                <?= Html::button('Cancel', ['class' => 'btn btn-sm btn-danger thread-section-cancel-button',
                    'data-id' => $thread_id]) ?>
                <?= Html::submitButton('Update', ['class' => 'btn btn-sm  btn-primary']) ?>
            </div>

        <?php  ActiveForm::end(); ?>
    </div>
