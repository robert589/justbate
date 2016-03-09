<?php
    use kartik\tabs\TabsX;
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use yii\widgets\Pjax;
    use yii\helpers\HtmlPurifier;
    $itemsHeader = [
        [
            'label' => 'Description',
            'content' => "<div style='font-size: 15px' align='left'>" . HtmlPurifier::process($description) . "</div>",
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

<?php Pjax::begin([
    'id' => 'edit_thread_pjax',
    'timeout' => false,
    'enablePushState' => false,
    'clientOptions'=>[
        'container' => '#edit_thread',
    ]
]);?>


<!-- Shown part-->
<div id="shown_part">
    <!-- Title part-->
    <div class="row" id="title-part">
        <div class="col-xs-12">
            <h3><b><?= Html::encode($title) ?></b> </h3>
        </div> <!-- div.col-md-12 -->
    </div> <!-- row -->

    <br>

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

        <div class="col-xs-12- col-md-6" id="edit_part">
            <div class="col-xs-12">
                <h3>Moderate Your Post</h3>
            </div> <!-- div.col-xs-12 -->
            <div class="col-xs-12">
                <?php
                $form = ActiveForm::begin([
                    'action' => ['thread/edit-thread'],
                    'method' => 'post',
                    'options' => ['data-pjax' => '#edit_thread']
                ])
                ?>
            </div> <!-- div.col-xs-6 -->
            <?= Html::hiddenInput('thread_id', $thread_id ) ?>
        </div>
    </div>

</div>
<!-- Edit part-->
<div id="edit_part" style="display:none">
    <br><br>



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
