<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Member */
/* @var $categories common\models\MemberCategory[] */
/* @var $form yii\bootstrap\ActiveForm */

backend\assets\CustomImperaviRedactorPluginAsset::register($this);
?>

<div class="member-form">

    <?php $form = ActiveForm::begin(); ?>    

    <?php echo $form->field($model, 'firstname')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'lastname')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'position')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'locale')->dropDownlist(Yii::$app->params['availableLocales']) ?>

    <?php
    echo $form->field($model, 'gender')->dropDownlist([
        common\models\Member::GENDER_FEMALE => Yii::t('backend', 'Female'),
        common\models\Member::GENDER_MALE   => Yii::t('backend', 'Male')
    ])
    ?>

    <?php
    echo $form->field($model, 'thumbnail')->widget(
        \trntv\filekit\widget\Upload::className(), [
        'url'         => ['/file-storage/upload'],
        'maxFileSize' => 5000000, // 5 MiB
    ]);
    ?>

    <?php echo $form->field($model, 'video')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'video_mobile')->textInput(['maxlength' => 255]) ?>
    <?php
    /* echo $form->field($model, 'attachments')->widget(
      \trntv\filekit\widget\Upload::className(), [
      'url'              => ['/file-storage/upload'],
      'sortable'         => true,
      'maxFileSize'      => 10000000, // 10 MiB
      'maxNumberOfFiles' => 10
      ]); */
    ?>

    <?php
    echo $form->field($model, 'weight')
        ->hint(Yii::t('backend', 'Used for sorting'))
        ->textInput(['maxlength' => 1024])
    ?>

    <?php echo $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?php
        echo Html::submitButton(
            $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord
                    ? 'btn btn-success' : 'btn btn-primary'])
        ?>
        <!--button type="button" class="btn btn-primary" id="previewButton">Preview</button-->
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
/*
  $js = '$("#previewButton").click(function() {'
  . 'var url = "' . Yii::getAlias('@frontendUrl/member/preview/'). '" + $("#member-slug").val();'
  . 'url = url + "?" + $("#' . $form->id . '").serialize();'
  . 'window.open(url,"Preview");'
  . '});';

  $this->registerJs($js); */
?>