<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('backend', 'Projects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
        echo Html::a(
            Yii::t('backend', 'Create {modelClass}', ['modelClass' => 'Project']), ['create'], ['class' => 'btn btn-success'])
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
            [
                'attribute' => 'category_id',
                'value'     => function ($model) {
                    return $model->category ? $model->category->title : null;
                },
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\ProjectCategory::find()->all(), 'id', 'title')
            ],
            [
                'attribute' => 'author_id',
                'value'     => function ($model) {
                    return $model->author->username;
                }
            ],
            [
                'class'     => \common\grid\EnumColumn::className(),
                'attribute' => 'status',
                'enum'      => [
                    Yii::t('backend', 'Not Published'),
                    Yii::t('backend', 'Published')
                ]
            ],
            'published_at:datetime',
            'created_at:datetime',
            'weight',            
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ]
        ]
    ]);
    ?>

</div>
