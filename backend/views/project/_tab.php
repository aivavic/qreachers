<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $categories common\models\ProjectCategory[] */
/* @var $form yii\bootstrap\ActiveForm */

//backend\assets\CustomImperaviRedactorPluginAsset::register($this);
?>

<div class="project-form">
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
                'categories' => $categories,
                'categoriesSecond' => $categoriesSecond,
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
        <!--button type="button" class="btn btn-primary" id="previewButton">Preview</button-->
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
/*$js = '$("#previewButton").click(function() {'
    . 'var url = "' . Yii::getAlias('@frontendUrl/project/preview/') . '" + $("#projectruru-slug").val();'
    . 'url = url + "?" + $("#' . $form->id . '").serialize();'
    . 'window.open(url,"Preview");'
    . '});';

$this->registerJs($js);*/
?>