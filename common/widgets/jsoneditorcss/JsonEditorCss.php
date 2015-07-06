<?php

namespace common\widgets\jsoneditorcss;

use yii\base\Widget;
use Yii;

class JsonEditorCss extends Widget
{
    /**
     * @var attribute element id
     */
    public $fieldId;

    /**
     * @var 
     */
    public $options;

    public function init()
    {
        //set default values
        if (empty($this->options['theme'])) {
            $this->options['theme'] = 'bootstrap3';
        }

        if (empty($this->options['disable_edit_json'])) {
            $this->options['disable_edit_json'] = true;
        }

        if (empty($this->options['disable_properties'])) {
            $this->options['disable_properties'] = true;
        }

        if (empty($this->options['iconlib'])) {
            $this->options['iconlib'] = 'bootstrap3';
        }

        if (empty($this->options['collapsed'])) {
            $this->options['collapsed'] = true;
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        $content = '<div id="' . $this->fieldId . '_holder" class="medium-12 columns"></div>';

        
        $js = 'var fieldId="' . $this->fieldId .'";';
        $js .= 'var jsonEncodeOptions = \'' . json_encode($this->options)  . '\';';
                
        $js .= file_get_contents(Yii::getAlias('@common/widgets/jsoneditorcss/assets/js.js'));
        
        \common\widgets\jsoneditorcss\assets\JsonEditorCssAsset::register($this->view);

        $this->view->registerJs($js);
        $this->view->registerJs(file_get_contents(Yii::getAlias('@common/widgets/jsoneditorcss/assets/yii2-widgets-integration.js')));

        return $content;
    }
}