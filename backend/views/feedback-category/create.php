<?php
/* @var $this yii\web\View */
/* @var $model common\models\FeedbackCategory */
/* @var $categories common\models\FeedbackCategory[] */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Feedback Category',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Feedback Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-category-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'categories' => $categories
    ]) ?>

</div>
