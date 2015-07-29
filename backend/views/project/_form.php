<?php
$mId = strtolower($model::getClassNameNoNamespace());

$categoriesList = \yii\helpers\ArrayHelper::map(
        $categories, 'id', 'title', 'parent_id'
);


foreach ($categoriesList as $key => $value) {
    if (!empty($key)) {
        $multiCategories[$categoriesList[''][$key]] = $value;
    }
}
//yii\helpers\VarDumper::dump($multiCategories, 11, 1);
//die();

?>


<?php echo $form->field($model, 'title')->textInput(['maxlength' => 512]) ?>

<?php
echo $form->field($model, 'slug')
    ->hint(Yii::t('backend', 'If you\'ll leave this field empty, slug will be generated automatically'))
    ->textInput(['maxlength' => 1024])
?>

<?php echo $form->field($model, 'description')->textInput(['maxlength' => 512]) ?>

<?php



echo $form->field($model, 'categoriesList')->dropDownList(
    $multiCategories, ['prompt' => '', 'multiple' => true]
);

$js = '$("#' . $mId . '-categorieslist").select2();';
$this->registerJs($js);
?>

<?php
echo $form->field($model, 'weight')
    ->hint(Yii::t('backend', 'Used for sorting'))
    ->textInput(['maxlength' => 1024])
?>

<?php
echo $form->field($model, 'head')->textarea([ 'style' => 'display:none;'])->label(false);

echo common\widgets\jsoneditorcss\JsonEditorCss::widget([
    'fieldId' => $mId . '-head',
    'options' => [
        'schema' => json_decode(file_get_contents(Yii::getAlias('@common/widgets/jsoneditorcss/assets/schema/backend.project.head.json')), true)
    ]
]);
?>

<?php
/* echo common\widgets\jsoneditorcss\Upload::widget([
  'editorKey' => $mId . '-head',
  'fieldName' => 'root[common][image][content]'
  ]); */
?>

<?php
echo $form->field($model, 'body')->textarea([ 'style' => 'display:none;'])->label(false);
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12">
<?php
echo common\widgets\jsoneditor\JsonEditor::widget([
    'fieldId'   => $mId . '-body',
    'schemaUrl' => Yii::getAlias('@web/js/json-editor/schema/project.body.json')
]);
?>
    </div>
</div>

<?php
echo $form->field($model, 'thumbnail')->widget(
    \trntv\filekit\widget\Upload::className(), [
    'url'         => ['/file-storage/upload'],
    'maxFileSize' => 5000000, // 5 MiB
]);
?>

<?php
echo $form->field($model, 'video')->widget(
    \trntv\filekit\widget\Upload::className(), [
    'url'         => ['/file-storage/upload'],
    'maxFileSize' => 10000000, // 10 MiB
]);
?>

<?php
echo $form->field($model, 'attachments')->widget(
    \trntv\filekit\widget\Upload::className(), [
    'url'              => ['/file-storage/upload'],
    'sortable'         => true,
    'maxFileSize'      => 10000000, // 10 MiB
    'maxNumberOfFiles' => 10
]);
?>

<?php
echo $form->field($model, 'domain')->dropDownList($domains, ['prompt' => '', 'multiple' => true]);

$js = '$("#' . $mId . '-domain").select2();';
$this->registerJs($js);
?>

<?php
echo $form->field($model, 'published_at')->widget(
    'trntv\yii\datetimepicker\DatetimepickerWidget', [
    'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ'
    ]
)
?>

<?php echo $form->field($model, 'status')->checkbox() ?>
