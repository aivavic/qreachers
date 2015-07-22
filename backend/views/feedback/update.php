<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Feedback */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Feedback',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Feedbacks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="feedback-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
        'domains' => $domains,
    ]) ?>

</div>
