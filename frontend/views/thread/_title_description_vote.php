<?php
    use kartik\tabs\TabsX;
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use yii\widgets\Pjax;

    $itemsHeader = [
        [
            'label' => 'Description',
            'content' => "<blockquote id='quote-on-thread' style='text-align: right; margin: 0 !important;'><h3>" . $description . "</h3></blockquote>",
            'active' => true,
        ],
        [

            'label' => 'Vote',
            'content' => $this->render('_submit_vote_pjax', ['thread_id' => $thread_id,
                                                            'user_choice' => $user_choice,
                                                            'thread_choices' => $thread_choices,
                                                            'submitVoteModel' => $submitVoteModel]),
            'active' => false
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
<div id="shown_part" style="display:block">

    <!-- Title part-->
    <div class="row" style="text-align: center;">
        <div class="col-md-12">
            <h1><?= $title ?> </h1>
        </div> <!-- div.col-md-12 -->
    </div> <!-- row -->


    <!-- First tab part -->
    <div class="row" style="border-color: #ccccff;min-height: 250px">
        <?= // Ajax Tabs Above
        TabsX::widget([
            'items'=>$itemsHeader,
            'position'=>TabsX::POS_ABOVE,
            'encodeLabels'=>false
        ]) ?>
    </div>
</div>
<!-- Edit part-->
<div id="edit_part" style="display:none">
    <br><br>

    <?php $form = ActiveForm::begin(['action' => ['thread/edit-thread'], 'method' => 'post', 'options' => ['data-pjax' => '#edit_thread']])?>

        <?= Html::hiddenInput('thread_id', $thread_id ) ?>
    
        <div class="row">
            <?= Html::input('text','title', $title, ['placeholder' => 'Title..', 'class' => 'form-control']) ?>
        </div>

        <div class="row" >
            <?= \yii\redactor\widgets\Redactor::widget([
                'value' => $description,
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

