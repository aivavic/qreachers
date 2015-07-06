<?php
/* @var $this yii\web\View */
/* @var $model common\models\ClientCategory */
/* @var $categories common\models\ClientCategory[] */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Client Category',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Client Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-category-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'categories' => $categories
    ]) ?>

</div>
