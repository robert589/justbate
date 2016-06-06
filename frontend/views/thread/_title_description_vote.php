<?php
    use kartik\tabs\TabsX;
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use yii\widgets\Pjax;
    use yii\helpers\HtmlPurifier;
    use common\components\Constant;
/** @var $thread \common\entity\ThreadEntity */
/** @var $submit_vote_form \frontend\models\SubmitThreadVoteForm */

if(!isset($vote_tab_active)){
    $vote_tab_active = true;
}

/**
 * VARIABLE USED
 */
$current_user_choice = $thread->getCurrentUserChoice();
$choices_in_thread = $thread->getChoices();
$description = $thread->getDescription();
$title = $thread->getTitle();
$thread_id = $thread->getThreadId();

Pjax::begin([
    'id' => 'edit_thread_pjax',
    'timeout' => false,
    'enablePushState' => false,
    'clientOptions'=>[
        'container' => '#edit_thread',
    ]]
);

?>
    <!-- Shown part-->
    <div id="shown_title_description_part">
        <div class="col-xs-12 thread-title">
            <?= Html::encode($title) ?>
        </div>
        <div id='post-description' align="center">
            <?= HtmlPurifier::process($description, Constant::DefaultPurifierConfig())
            ?>
        </div>

    </div>
    <!-- Edit part-->
    <div id="edit_title_description_part" style="display: none">

<?php
    $form = ActiveForm::begin([
        'action' => ['thread/edit-thread'],
        'method' => 'post',
        'options' => ['data-pjax' => '#edit_thread']
    ])
?>

        <?= Html::hiddenInput('thread_id', $thread_id ) ?>

        <div class="row">
             <?= Html::input('text','title', $title, ['placeholder' => 'Title..', 'class' => 'form-control']) ?>
        </div>

        <div class="row">
            <?= \yii\redactor\widgets\Redactor::widget([
                'name' => 'description',
                'value' => HtmlPurifier::process($description, Constant::DefaultPurifierConfig()),
                'clientOptions' => [
                    'imageUpload' => \yii\helpers\Url::to(['/redactor/upload/image']),
                ],
            ]) ?>
        </div>

        <div class="row" align="right">
            <?= Html::button('Cancel', ['class' => 'btn btn-danger', 'id' => 'cancel_edit_thread_button']) ?>
            <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
        </div>

<?php
    ActiveForm::end();
?>

    </div>

<?php
    Pjax::end();

