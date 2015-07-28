<?php
/* @var $this yii\web\View */
/* @var $model common\models\Block */
/* @var $categories common\models\BlockCategory[] */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Block',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Blocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="block-create">

    <?php echo $this->render('_tab', [
        'model' => $model,        
        'domains' => $domains
    ]) ?>

</div>
