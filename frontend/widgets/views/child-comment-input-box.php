<?php
use yii\helpers\Html;
use common\widgets\AutoHeightTextArea;
use common\libraries\UserUtility;
/** @var $comment_id integer */
/** @var $child_comment_form \frontend\models\ChildCommentForm */
if(Yii::$app->user->isGuest) {
    $photo_path = 'default.png';
} else {
    $photo_path= Yii::$app->user->identity->photo_path;
}
?>

<div id="<?= $id ?>" class="child-comment-input-box-container">
    <div class="child-comment-input-box-form-area">
        <?= Html::img(UserUtility::buildPhotoPath($photo_path), 
                ['class' => 'child-comment-input-box-img']) ?>
        <?= AutoHeightTextArea::widget(
            ['widget_class' => 'child-comment-input-box-text-area', 
            'placeholder' => 'Write comment here..',
            'options' =>[
                'data-id' => $id, 'data-parent_id' => $parent_id
                ]
            ]) ?>
        
    </div>
    <div class="child-comment-input-box-loading-comment-list">
        
    </div>
    <div class="child-comment-input-box-new-comment-list">
        
    </div>
</div>
