<?php
/* @var $this yii\web\View */
/* @var $model common\models\MemberCategory */
/* @var $categories common\models\MemberCategory[] */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Member Category',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Member Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-category-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'categories' => $categories
    ]) ?>

</div>
