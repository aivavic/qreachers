<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Client */
/* @var $categories common\models\ClientCategory[] */
/* @var $form yii\bootstrap\ActiveForm */

backend\assets\CustomImperaviRedactorPluginAsset::register($this);
?>

<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => 512]) ?>

    <?php
    echo $form->field($model, 'slug')
        ->hint(Yii::t('backend', 'If you\'ll leave this field empty, slug will be generated automatically'))
        ->textInput(['maxlength' => 1024])
    ?>

    <?php
    /*echo $form->field($model, 'category_id')->dropDownList(\yii\helpers\ArrayHelper::map(
            $categories, 'id', 'title'
        ), ['prompt' => ''])*/
    ?>

    <?php
    echo $form->field($model, 'weight')
        ->hint(Yii::t('backend', 'Used for sorting'))
        ->textInput(['maxlength' => 1024])
    ?>

    <?php
    /*echo $form->field($model, 'head')->textarea([ 'style' => 'display:none;'])->label(false);

    echo common\widgets\jsoneditorcss\JsonEditorCss::widget([
        'fieldId' => 'client-head',
        'options' => [
            'schema' => json_decode(file_get_contents(Yii::getAlias('@common/widgets/jsoneditorcss/assets/schema/backend.client.head.json')), true)
        ]
    ]);*/
    ?>

    <?php
    /*echo common\widgets\jsoneditorcss\Upload::widget([
        'editorKey' => 'client-head',
        'fieldName' => 'root[common][image][content]'
    ]);*/
    ?>

    <?php
    /*echo $form->field($model, 'body')->widget(
        \yii\imperavi\Widget::className(), [
        'plugins' => ['fullscreen', 'fontcolor', 'video'],
        'options' => [
            'minHeight'       => 400,
            'maxHeight'       => 400,
            'buttonSource'    => true,
            'convertDivs'     => false,
            'replaceDivs'     => false,
            'removeEmptyTags' => false,
            'imageUpload'     => Yii::$app->urlManager->createUrl(['/file-storage/upload-imperavi']),
        ]
        ]
    )*/
    ?>

    <?php
    /*echo $form->field($model, 'body')->textarea([ 'style' => 'display:none;'])->label(false);

    echo common\widgets\jsoneditorcss\JsonEditorCss::widget([
        'fieldId' => 'client-body',
        'options' => [
            'schema' => json_decode(file_get_contents(Yii::getAlias('@common/widgets/jsoneditorcss/assets/schema/backend.client.body.json')), true)
        ]
    ]);*/
    ?>

    <?php
    echo $form->field($model, 'thumbnail')->widget(
        \trntv\filekit\widget\Upload::className(), [
        'url'         => ['/file-storage/upload'],
        'maxFileSize' => 5000000, // 5 MiB
    ]);
    ?>

    <?php
    /*echo $form->field($model, 'attachments')->widget(
        \trntv\filekit\widget\Upload::className(), [
        'url'              => ['/file-storage/upload'],
        'sortable'         => true,
        'maxFileSize'      => 10000000, // 10 MiB
        'maxNumberOfFiles' => 10
    ]);*/
    ?>

    <?php echo $form->field($model, 'status')->checkbox() ?>

    <?php
    /*echo $form->field($model, 'published_at')->widget(
        'trntv\yii\datetimepicker\DatetimepickerWidget', [
        'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ'
        ]
    )*/
    ?>

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
    . 'var url = "' . Yii::getAlias('@frontendUrl/client/preview/'). '" + $("#client-slug").val();'
    . 'url = url + "?" + $("#' . $form->id . '").serialize();'
    . 'window.open(url,"Preview");'
    . '});';

$this->registerJs($js);*/
?>