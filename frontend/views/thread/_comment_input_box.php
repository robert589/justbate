<!--Comment Input Part-->
<?php $form =ActiveForm::begin(['id' => 'comment-form']) ?>

<div class="row">
    <div class="col-md-offset-2	col-md-5">
        <?= $form->field($commentModel, 'comment')->textArea(['id' => 'comment-box', 'placeholder' => 'add comment box...', 'rows' => 2 ]) ?>
    </div>
    <div class="col-md-4">
        <label> Choose your Comment Side </label>
        <?= $form->field($commentModel, 'yes_or_no')->widget(Select2::classname(), [
            'data' => [1 => 'Agree', 0 => 'Disagree'],
            'options' => ['placeholder' => 'Select a state ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label(false) ?>
    </div>

</div>

<?php ActiveForm::end(); ?>