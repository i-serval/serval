<?php

namespace common\components\datetimepicker\widget;

use Yii;
use yii\base\Model;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use common\models\serval\helper\DateTimeHelper;
use common\components\datetimepicker\widget\DateTimePickerAsset;

class DateTimePicker extends \yii\base\Widget
{

    public $containerOptions = [];  // field container options
    public $name;                   // input name
    public $inline = false;         // display inline picker
    public $model;                  // form model
    public $attribute;              // form model attribute name
    public $value;                  // input value
    public $format;                 // format for input value
    public $pluginOptions = [];     // array set as json config to datetimepicker
    public $language;               // locale
    public $container_id;           // container id for form field

    // input and div tags wrapper configuration
    public $options = [             // options for input tag
        'class' => 'form-control'
    ];

    public $type = 'date-time';     // date-time, date, time

    protected $divTagClasses = [
        'date-time' => 's-widget-date-time',
        'date' => 's-widget-date',
        'time' => 's-widget-time',
    ];

    protected $divTagOptions = [
        'class' => 'input-group date',
        'id' => null
    ];

    //  icon image configuration
    protected $spanTagOptions = [
        'class' => 'glyphicon',
    ];

    public $noIcon = false;                     // switch on/off icon image near input
    public $iconClass = 'glyphicon-calendar';   // icon image near input
    public $wrapperCssClass = null;
    protected $defaultPlaginOptions = [];

    public function init()
    {

        if ($this->hasModel() && !isset($this->options['id'])) {
            $this->options['id'] = Html::getInputId($this->model, $this->attribute);
        }

        parent::init();

        if ($this->inline && !isset($this->containerOptions['id'])) {
            $this->containerOptions['id'] = $this->options['id'] . '-container';
        }

        $this->initDefaulPlaginOptions();

        if( $this->wrapperCssClass != null) {
            $this->divTagOptions['class'] .= ' ' . $this->wrapperCssClass;
        }

        $this->pluginOptions = ArrayHelper::merge($this->defaultPlaginOptions, $this->pluginOptions);

    }

    public function run()
    {

        $container_id = $this->inline ? $this->containerOptions['id'] : $this->options['id'];
        $this->divTagOptions['id'] = $container_id;

        echo $this->renderWidget() . "\n";

        $options = Json::htmlEncode($this->pluginOptions);

        $this->getView()->registerJs("jQuery('#{$container_id}').datetimepicker($options);");

        DateTimePickerAsset::register($this->getView());

    }

    protected function renderWidget()
    {
        $contents = []; // input tag

        // get formatted date value
        if ($this->hasModel()) {
            $value = Html::getAttributeValue($this->model, $this->attribute);
        } else {
            $value = $this->value;
        }
        if ($value !== null && $value !== '') {
            // format value according to dateFormat
            try {
                $value = Yii::$app->formatter->asDatetime($value, $this->format);
            } catch (InvalidParamException $e) {
                // ignore exception and keep original value if it is not a valid date
            }
        }

        $options = $this->options;
        $options['value'] = $value;

        if ($this->inline === false) {
            // render a text input
            if ($this->hasModel()) {
                $contents[] = Html::activeTextInput($this->model, $this->attribute, $options);
            } else {
                $contents[] = Html::textInput($this->name, $value, $options);
            }
        } else {
            // render an inline date picker with hidden input
            if ($this->hasModel()) {
                $contents[] = Html::activeHiddenInput($this->model, $this->attribute, $options);
            } else {
                $contents[] = Html::hiddenInput($this->name, $value, $options);
            }

            $contents[] = Html::tag('div', null, $this->containerOptions);
        }

        $input_tag = implode("\n", $contents);

        $span_tags = '';

        if (!$this->noIcon) {
            $span_tags = Html::tag('span', Html::tag('span', null, $this->spanTagOptions), ['class' => 'input-group-addon']);
        }

        return Html::tag('div', $input_tag . $span_tags, $this->divTagOptions);

    }

    protected function hasModel()
    {

        return $this->model instanceof Model && $this->attribute !== null;

    }

    protected function initDefaulPlaginOptions()
    {

        $this->defaultPlaginOptions['locale'] = explode('-', Yii::$app->language)[0];

        $this->divTagOptions['class'] .= ' ' . $this->divTagClasses[$this->type];
        $this->spanTagOptions['class'] .= ' ' . $this->iconClass;


        if( $this->format == null ) {

            $format = null;

            if ($this->type == 'date-time') {
                $format = Yii::$app->formatter->datetimeFormat;
            } elseif ($this->type == 'date') {
                $format = Yii::$app->formatter->dateFormat;
            } elseif ($this->type == 'time') {
                $format = Yii::$app->formatter->timeFormat;
            }

            $this->defaultPlaginOptions['format'] = DateTimeHelper::convertPHPToMomentFormat($format);

        } else{

            $this->pluginOptions['format'] = DateTimeHelper::convertPHPToMomentFormat($this->format);

        }


    }

}
