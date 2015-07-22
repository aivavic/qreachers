<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Feedback */
/* @var $categories common\models\FeedbackCategory[] */
/* @var $form yii\bootstrap\ActiveForm */

backend\assets\CustomImperaviRedactorPluginAsset::register($this);
?>

<div class="feedback-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'nick')->textInput() ?>
    <?php echo $form->field($model, 'email')->textInput() ?>
    <?php echo $form->field($model, 'lang')->textInput() ?>
    <?php echo $form->field($model, 'message')->textarea() ?>

    <?php
    /*echo $form->field($model, 'category_id')->dropDownList(\yii\helpers\ArrayHelper::map(
            $categories, 'id', 'title'
        ), ['prompt' => ''])*/
    ?>
    
    <?php echo $form->field($model, 'status')->checkbox() ?>

    <?php
    echo $form->field($model, 'created_at')->widget(
        'trntv\yii\datetimepicker\DatetimepickerWidget', [
        'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ'
        ]
    )
    ?>

    <div class="form-group">
        <?php
        echo Html::submitButton(
            $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord
                    ? 'btn btn-success' : 'btn btn-primary'])
        ?>        
    </div>

    <?php ActiveForm::end(); ?>

</div>