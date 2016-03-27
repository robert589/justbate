<?php
    use kartik\tabs\TabsX;
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use yii\widgets\Pjax;
    use yii\helpers\HtmlPurifier;
/** @var  $description string */
/** @var $thread_id integer */
/** @var $user_choice array */
/** @var $thread_choices array */

/** @var $submitVoteModel \frontend\models\SubmitThreadVoteForm */

Pjax::begin([
    'id' => 'edit_thread_pjax',
    'timeout' => false,
    'enablePushState' => false,
    'clientOptions'=>[
        'container' => '#edit_thread',
    ]]
);

    $itemsHeader = [
        [
            'label' => 'Description',
            'content' => "<div id='post-description'>" . HtmlPurifier::process($description) . "</div>",
            'active' => isset($vote_tab_active) ? false: true,
        ],
        [

            'label' => 'Vote',
            'content' => $this->render('_submit_vote_pjax', ['thread_id' => $thread_id,
                                                            'user_choice' => $user_choice,
                                                            'thread_choices' => $thread_choices,
                                                            'submitVoteModel' => $submitVoteModel]),
            'active' => isset($vote_tab_active) ? true : false,
        ]
    ];

?>



<!-- Shown part-->
<div id="shown_part">
    <div class="col-xs-12 thread-title">
        <?= Html::encode($title) ?>
    </div>
    <!-- First tab part -->
    <div class="row" id="first-part">
        <div class="col-xs-12">
            <?= // Ajax Tabs Above
            TabsX::widget([
                'items'=>$itemsHeader,
                'position'=>TabsX::POS_ABOVE,
                'encodeLabels'=>false
            ]) ?>
        </div>
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
    <br><br>
    <br><br>

    <?= Html::hiddenInput('thread_id', $thread_id ) ?>

    <div class="row">
         <?= Html::input('text','title', $title, ['placeholder' => 'Title..', 'class' => 'form-control']) ?>
    </div>

    <div class="row">
        <?= \yii\redactor\widgets\Redactor::widget([
            'name' => 'description',
            'value' => HtmlPurifier::process($description),
            'clientOptions' => [
                'imageUpload' => \yii\helpers\Url::to(['/redactor/upload/image']),
            ],
        ]) ?>
    </div>

    <div class="row" align="right">
        <?= Html::button('Cancel', ['class' => 'btn btn-danger', 'id' => 'cancel_edit_thread_button']) ?>
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php   ActiveForm::end() ?>
</div>

<?php Pjax::end() ?>
