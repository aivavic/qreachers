<?php
/* @var $this yii\web\View */
/* @var $model common\models\ProjectCategorySecond */
/* @var $categories common\models\ProjectCategorySecond[] */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Project Category',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Project Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-category-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'categories' => $categories
    ]) ?>

</div>
