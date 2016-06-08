 <?php
    use yii\helpers\Html;
    use kartik\form\ActiveForm;
    use common\widgets\DeletableList;
    /** @var $followed_issue_list array */
    /** @var $issue_list array */

?>

<div class="container-fluid">

    <div class="row">
        <?= DeletableList::widget(['list' => array_column($followed_issue_list, 'label')]) ?>
    </div>

    <div class="row" id="home-issue-edit-header">
        Search issue
    </div>

    <div class="row">
        <?= Html::textInput('issue-query',
                            null,
                           ['placeholder' => 'Search Issue',
                            'class' => 'form-control',
                            'id' => 'home-issue-edit-input-text']) ?>
    </div>

    <div class="row">
        <?php $form = ActiveForm::begin() ?>

            <?php foreach($issue_list as $issue){ ?>


            <?php } ?>

        <?php ActiveForm::end(); ?>

    </div>



</div>

<script src="<?= Yii::$app->request->baseUrl . '/frontend/web/js/home-issue-edit.js' ?>"></script>