<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\CommentForm */

$this->title = 'Comment';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-comment">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to comment:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-comment']); ?>
                <?= $form->field($model, 'content') ?>             
                <div class="form-group">
                    <?= Html::submitButton('发表评论', ['class' => 'btn btn-primary', 'name' => 'comment-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php \yii2masonry\yii2masonry::begin([
    'clientOptions' => [
        'columnWidth' => 50,
        'itemSelector' => '.comment'
    ]
]); ?>

        <div class="comment"><h3>Test</h3><p>Und mehr Text</p></div>
        <div class="comment"><h3>Test</h3><p>Und mehr Text</p></div>
        <div class="comment"><h3>Test</h3><p>Und mehr Text</p></div>
        <div class="comment"><h3>Test</h3><p>Und mehr Text</p></div>
        <div class="comment"><h3>Test</h3><p>Und mehr Text</p></div>
        <div class="comment"><h3>Test</h3><p>Und mehr Text</p></div>
        <div class="comment"><h3>Test</h3><p>Und mehr Text</p></div>
        <div class="comment"><h3>Test</h3><p>Und mehr Text</p></div>
        <div class="comment"><h3>Test</h3><p>Und mehr Text</p></div>
        <div class="comment"><h3>Test</h3><p>Und mehr Text</p></div>
        <div class="comment"><h3>Test</h3><p>Und mehr Text</p></div>
        <div class="comment"><h3>Test</h3><p>Und mehr Text</p></div>

<?php \yii2masonry\yii2masonry::end(); ?>
<?php $this->registerCss(".comment { width: 25%; }  .comment.w2 { width: 50%; }");?>

