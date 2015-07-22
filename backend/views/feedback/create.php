<?php
/* @var $this yii\web\View */
/* @var $model common\models\Feedback */
/* @var $categories common\models\FeedbackCategory[] */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Feedback',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Feedbacks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
        'domains' => $domains,
    ]) ?>

</div>
