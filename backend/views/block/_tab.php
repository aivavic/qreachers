<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model common\models\Block */
/* @var $categories common\models\BlockCategory[] */
/* @var $form yii\bootstrap\ActiveForm */

//backend\assets\CustomImperaviRedactorPluginAsset::register($this);
?>

<div class="block-form">
    <?php
    $form = ActiveForm::begin();
    //print_r($model->getErrors());

    $items = [];
    foreach ($model->getModels() as $key => $value) {
        $currentModel = $model->getModel($key);
        $items[]      = [
            'label'   => Yii::$app->params['availableLocales'][$key],
            'content' => $this->render('_form', [
                'model'      => $currentModel,
                'form'      => $form,                
                'domains' => $domains
            ]),
        ];
    }


    echo Tabs::widget([
        'items' => $items
    ]);
    ?>

    <div class="form-group">
        <?php
        echo Html::submitButton(
            $model->getModel('ru-RU')->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->getModel('ru-RU')->isNewRecord
                    ? 'btn btn-success' : 'btn btn-primary'])
        ?>
        
    </div>

    <?php ActiveForm::end(); ?>

</div>

