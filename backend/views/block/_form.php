<?php
$mId = strtolower($model::getClassNameNoNamespace());

//yii\helpers\VarDumper::dump($model,11,1);
?>


<?php echo $form->field($model, 'title')->textInput(['maxlength' => 1024]) ?>

<?php
echo $form->field($model, 'slug')
    ->hint(Yii::t('backend', 'If you\'ll leave this field empty, slug will be generated automatically'))
    ->textInput(['maxlength' => 1024])
?>

<?php echo $form->field($model, 'description')->textInput(['maxlength' => 1024]) ?>

<?php
echo $form->field($model, 'body')->textarea([ 'style' => 'display:none;'])->label(false);
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <?php
        echo common\widgets\jsoneditor\JsonEditor::widget([
            'fieldId'   => $mId . '-body',
            'schemaUrl' => Yii::getAlias('@web/js/json-editor/schema/block.body.json')
        ]);
        ?>
    </div>
</div>

<?php
echo $form->field($model, 'domain')->dropDownList($domains, ['prompt' => '', 'multiple' => true]);

$js = '$("#' . $mId . '-domain").select2();';
$this->registerJs($js);
?>

<?php echo $form->field($model, 'status')->checkbox() ?>
