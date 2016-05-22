<?php
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $thread \common\entity\ThreadEntity **/
/* @var $comment_model \frontend\models\CommentForm */
/** @var $comment_input_retrieved boolean */

/**
 * Variable Used
 */
$thread_id = $thread->getThreadId();
$thread_choices = $thread->getChoices();

Pjax::begin([
    'id' => 'comment_input_' . $thread_id,
    'enablePushState' => false,
    'timeout' => false,
    'options' => [
        'class' => 'comment_input_pjax',
        'data-service' => $thread_id,
        'container' => '#comment_input_' . $thread_id
    ]
]);

if(isset($comment_input_retrieved)) {

    //prepare data
    $choice_text = array();

    foreach ($thread_choices as $choice) {
        $choice_text[$choice['choice_text']] = $choice['choice_text'];
    }

?>


<!--Comment Input Part-->
<?php
    $form = ActiveForm::begin(['action' => ['thread/submit-comment'],
                    'options' => ['class' => 'comment-form',
                    'data-pjax' => '#comment_input_' . $thread_id]]) ?>

    <div class="col-xs-12" id="comment_input_box_section_<?= $thread_id ?>">

        <div class="row">
            <div class="col-xs-12" id="redactor_box_<?= $thread_id ?>">
                <?=  $form->field($comment_model,
                                  'comment',
                                  [
                                      'selectors' => ['input' => '#comment-input-' . $thread_id]
                                  ])
                          ->widget(\yii\redactor\widgets\Redactor::className(),
                                  [
                                       'options' => [
                                           'id' => 'comment-input-' . $thread_id,
                                       ],
                                       'clientOptions' => [
                                           'imageUpload' => \yii\helpers\Url::to(['/redactor/upload/image']),
                                       ],
                                   ])->label(false)
                ?>

            </div>
        </div>

        <div class="row">
            <div class="col-xs-6">
                <?= $form->field($comment_model, 'choice_text')
                         ->widget(Select2::classname(),
                                ['data' => $choice_text,
                                 'hideSearch' => true,
                                 'options' => ['placeholder' => 'Choose your side ...',
                                              'id' => 'comment_choice_text_' . $thread_id],
                                 'pluginOptions' => [
                                    'allowClear' => true
                                ]])
                         ->label(false) ?>
            </div>

            <div align="right" class="col-xs-6">
                <?= Html::hiddenInput('thread_id', $thread_id) ?>
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'style' => 'width: 100%;']) ?>
            </div>


        </div>

    </div>

<?php
    ActiveForm::end();
}

Pjax::end() ;

?>