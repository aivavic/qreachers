<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\BlockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('backend', 'Blocks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="block-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
        echo Html::a(
            Yii::t('backend', 'Create {modelClass}', ['modelClass' => 'Block']), ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [

            'id',
            'slug',
            'title',
            'description',
            'domain',
            [
                'class'     => \common\grid\EnumColumn::className(),
                'attribute' => 'status',
                'enum'      => [
                    Yii::t('backend', 'Not Published'),
                    Yii::t('backend', 'Published')
                ]
            ],            
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ]
        ]
    ]);
    ?>

</div>
