<?php

namespace common\components\widgets\datetime;

use Yii;
use yii\base\Model;
//use yii\base\InvalidParamException;
///use yii\helpers\FormatConverter;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use common\components\widgets\datetime\DateTimePickerAsset;

class DateTimePicker extends \yii\base\Widget
{

    protected $clientEventMap = [];
    public $clientOptions = [];
    public $clientEvents = [];
    public $containerOptions = []; // field container options
    public $name;
    public $inline = false;         // display inline picker
    public $model;                  // form model
    public $attribute;              // form model attribute name
    public $value;                  // input value
    public $dateTimeFormat;         // format for input value
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

    public function init()
    {

        if ($this->hasModel() && !isset($this->options['id'])) {
            $this->options['id'] = Html::getInputId($this->model, $this->attribute);
        }

        parent::init();

        if ($this->inline && !isset($this->containerOptions['id'])) {
            $this->containerOptions['id'] = $this->options['id'] . '-container';
        }

        if ($this->dateTimeFormat === null) {
            $this->dateTimeFormat = Yii::$app->formatter->datetimeFormat;
        }

        $this->divTagOptions['class'] .= ' ' . $this->divTagClasses[$this->type];
        $this->spanTagOptions['class'] .= ' ' . $this->iconClass;

    }

    public function run()
    {

        $container_id = $this->inline ? $this->containerOptions['id'] : $this->options['id'];
        $this->divTagOptions['id'] = $container_id;

        echo $this->renderWidget() . "\n";


        $language = $this->pluginOptions['locale'] ? $this->pluginOptions['locale'] : Yii::$app->language;


        // залежно від нашого формату втсновлюємо необхідний для жабаскрипт плагіну
        /*if (strncmp($this->dateTimeFormat, 'php:', 4) === 0) {
            $this->clientOptions['dateTimeFormat'] = FormatConverter::convertDatePhpToJui(substr($this->dateTimeFormat, 4));
        } else {
            $this->clientOptions['dateTimeFormat'] = FormatConverter::convertDateIcuToJui($this->dateTimeFormat, 'date', $language);
        }*/

        //$this->registerClientEvents('datepicker', $containerID);

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
                $value = Yii::$app->formatter->asDatetime($value, $this->dateTimeFormat);
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
            $this->clientOptions['defaultDate'] = $value;
            $this->clientOptions['altField'] = '#' . $this->options['id'];
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

    /*protected function registerClientOptions($name, $id)
    {
        if ($this->clientOptions !== false) {
            $options = empty($this->clientOptions) ? '' : Json::htmlEncode($this->clientOptions);
            $js = "jQuery('#$id').$name($options);";
            $this->getView()->registerJs($js);
        }
    }*/

    /**
     * Registers a specific jQuery UI widget events
     * @param string $name the name of the jQuery UI widget
     * @param string $id the ID of the widget
     */
   /* protected function registerClientEvents($name, $id)
    {
        if (!empty($this->clientEvents)) {
            $js = [];
            foreach ($this->clientEvents as $event => $handler) {
                if (isset($this->clientEventMap[$event])) {
                    $eventName = $this->clientEventMap[$event];
                } else {
                    $eventName = strtolower($name . $event);
                }
                $js[] = "jQuery('#$id').on('$eventName', $handler);";
            }
            $this->getView()->registerJs(implode("\n", $js));
        }
    }*/

    /**
     * Registers a specific jQuery UI widget asset bundle, initializes it with client options and registers related events
     * @param string $name the name of the jQuery UI widget
     * @param string $id the ID of the widget. If null, it will use the `id` value of [[options]].
     */
   /* protected function registerWidget($name, $id = null)
    {
        if ($id === null) {
            $id = $this->options['id'];
        }
        JuiAsset::register($this->getView());
        $this->registerClientEvents($name, $id);
        $this->registerClientOptions($name, $id);
    }*/

}
