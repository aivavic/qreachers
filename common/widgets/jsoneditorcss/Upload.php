<?php

namespace common\widgets\jsoneditorcss;

use yii\base\Widget;
use Yii;

class Upload extends Widget
{
    /**
     * @var attribute element id
     */
    public $fieldName;
    public $editorKey;

    /**
     * @var 
     */
    public $options;

    /**
     * @var
     */
    public $originConfig = [];
    public $blockId;
    private $fieldId;
    private $fieldEditorKey;

    public function init()
    {
        //set default values
        if (empty($this->fieldName))
                throw new Exception('upload fieldName required');
        if (empty($this->editorKey))
                throw new Exception('upload editorKey required');

        $this->fieldId        = trim(str_replace(['][', '[', ']'], '-', $this->fieldName), '-');
        $this->fieldEditorKey = str_replace('-', '.', $this->fieldId);

        if (empty($this->originConfig['name'])) {
            $this->originConfig['name'] = $this->fieldName;
        }

        if (empty($this->originConfig['options'])) {
            $this->originConfig['options'] = ['id' => $this->fieldId];
        }

        if (empty($this->originConfig['url'])) {
            $this->originConfig['url'] = ['/file-storage/upload'];
        }

        if (empty($this->originConfig['maxFileSize'])) {
            $this->originConfig['maxFileSize'] = 5000000;
        }

        if (empty($this->blockId)) {
            $this->blockId = 'block-' . $this->fieldId;
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        $content = '<span id="' . $this->blockId . '" style="display:none;"><br>';

        $content .= \trntv\filekit\widget\Upload::widget($this->originConfig);

        $js = 'setTimeout(function(){ ';
        $js .= 'var block = $("#' . $this->blockId . '").detach();';
        $js .= '$(\'input[name="' . $this->fieldName . '"]\').parent().append(block);';
        $js .= '$("#' . $this->blockId . '").show();';
        $js .= '$("#' . $this->blockId . '").change(function(){ setTimeout(function() ';
        $js .= '{ var src = $("#' . $this->blockId . '").find(\'img\').attr(\'src\'); var content = window.jsoneditorcsseditors[\'' . $this->editorKey . '\'].getEditor(\'' . $this->fieldEditorKey . '\'); content.setValue(src); },2000); });';
        $js .= '},3000);';

        $content .= '</span>';

        $this->view->registerJs($js);

        return $content;
    }
}