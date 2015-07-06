<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('backend', 'Members');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
        echo Html::a(
            Yii::t('backend', 'Create {modelClass}', ['modelClass' => 'Member']), ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            //'id',
            //'slug',
            'firstname',            
            'lastname',
            'position',
            //'video',
            //echo $form->field($model, 'locale')->dropDownlist(Yii::$app->params['availableLocales'])
            //UserProfile::GENDER_FEMALE => Yii::t('backend', 'Female'),
            //UserProfile::GENDER_MALE => Yii::t('backend', 'Male')
            [
                'class'     => \common\grid\EnumColumn::className(),
                'attribute' => 'gender',
                'enum'      => [
                    '1' => Yii::t('backend', 'Male'),
                    '2' => Yii::t('backend', 'Female'),
                ]
            ],
            [
                'class'     => \common\grid\EnumColumn::className(),
                'attribute' => 'locale',
                'enum'      => Yii::$app->params['availableLocales']
            ],            
            [
                'class'     => \common\grid\EnumColumn::className(),
                'attribute' => 'status',
                'enum'      => [
                    Yii::t('backend', 'Not Active'),
                    Yii::t('backend', 'Active')
                ]
            ],
            //'created_at:datetime',
            'weight',
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ]
        ]
    ]);
    ?>

</div>
