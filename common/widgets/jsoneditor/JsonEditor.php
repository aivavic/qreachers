<?php

namespace common\widgets\jsoneditor;

use yii\base\Widget;
use Yii;

class JsonEditor extends Widget
{
    /**
     * @var attribute element id
     */
    public $fieldId;

    /**
     * @var attribute base schema url
     */
    public $schemaUrl;

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

        if (empty($this->options['ajax'])) {
            $this->options['ajax'] = true;
        }

        if (empty($this->options['no_additional_properties'])) {
            // Disable additional properties
            $this->options['no_additional_properties'] = true;
        }

        if (empty($this->options['required_by_default'])) {
            // Require all properties by default
            $this->options['required_by_default'] = true;
        }

        $this->options['schema'] = ['$ref' => $this->schemaUrl];
    }

    /**
     * @return string
     */
    public function run()
    {
        \common\widgets\jsoneditor\assets\JsonEditorAsset::register($this->view);

        $content = '<div id="' . $this->fieldId . '_holder" ></div>';
        $content .= '<style>.tab-content > .tab-pane label { padding-top:30px; padding-left:15px;}</style>';
        $content .= '<style>.tab-content > .tab-pane input { padding:3px;}</style>';
        $content .= '<style>.tab-content > .tab-pane .container-fluid { padding-bottom:30px;}</style>';
        $content .= '<style>.sceditor-button div { margin-left: -3px;  margin-top: -3px;} .sceditor-button {margin: 2px;} </style>';
        $content .= '<style>.select2-container-multi { border: none;  padding: 0;} </style>';
        $content .= '<style>.select2-container { border: none;  padding: 0;} </style>';

        $conf    = [
            'fieldId' => $this->fieldId,
            'options' => $this->options,
            'debug'   => YII_DEBUG,
        ];



        $js = 'var conf = \'' . json_encode($conf) . '\';';
        $js .= file_get_contents(Yii::getAlias('@common/widgets/jsoneditor/assets/js/init.js'));

        $this->view->registerJs($js);

        return $content;
    }
}