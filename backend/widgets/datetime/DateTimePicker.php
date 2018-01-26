<?php

namespace backend\widgets\datetime;

use Yii;
use yii\base\InvalidParamException;
use yii\helpers\FormatConverter;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\jui\InputWidget;

use yii\helpers\ArrayHelper;
use backend\assets\DateTimePickerAsset;

class DateTimePicker extends \yii\base\Widget
{

    protected $clientEventMap = [];
    public $options = [];
    public $clientOptions = [];
    public $clientEvents = [];
    public $language;
    public $containerOptions = [];
    public $dateFormat;
    public $model;
    public $attribute;
    public $inline = false;
    public $value;
    public $name;

    public function init()
    {

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

        if ($this->hasModel() && !isset($this->options['id'])) {
            $this->options['id'] = Html::getInputId($this->model, $this->attribute);
        }

        parent::init();

        if ($this->inline && !isset($this->containerOptions['id'])) {
            $this->containerOptions['id'] = $this->options['id'] . '-container';
        }
        if ($this->dateFormat === null) {
            $this->dateFormat = Yii::$app->formatter->dateFormat;
        }
    }

    /**
     * Renders the widget.
     */
    public function run()
    {

//        var_dump($this);

//        var_dump($this->renderWidget() . "\n");

//        die();

        echo $this->renderWidget() . "\n";

        $containerID = $this->inline ? $this->containerOptions['id'] : $this->options['id'];
        $language = $this->language ? $this->language : Yii::$app->language;

        if (strncmp($this->dateFormat, 'php:', 4) === 0) {
            $this->clientOptions['dateFormat'] = FormatConverter::convertDatePhpToJui(substr($this->dateFormat, 4));
        } else {
            $this->clientOptions['dateFormat'] = FormatConverter::convertDateIcuToJui($this->dateFormat, 'date', $language);
        }

        if ($language !== 'en-US') {
            $view = $this->getView();
            //$assetBundle = DatePickerLanguageAsset::register($view);
            //$assetBundle->language = $language;
            $options = Json::htmlEncode($this->clientOptions);
            $language = Html::encode($language);
            //$view->registerJs("jQuery('#{$containerID}').datepicker($.extend({}, $.datepicker.regional['{$language}'], $options));");
            $view->registerJs("jQuery('#{$containerID}').datetimepicker({locale: 'ru'});");
        } else {
            $this->registerClientOptions('datepicker', $containerID);
        }

        $this->registerClientEvents('datepicker', $containerID);
        //JuiAsset::register($this->getView());
        DateTimePickerAsset::register($this->getView());
    }

    /**
     * Renders the DatePicker widget.
     * @return string the rendering result.
     */
    protected function renderWidget()
    {
        $contents = [];

        // get formatted date value
        if ($this->hasModel()) {
            $value = Html::getAttributeValue($this->model, $this->attribute);
        } else {
            $value = $this->value;
        }
        if ($value !== null && $value !== '') {
            // format value according to dateFormat
            try {
                $value = Yii::$app->formatter->asDate($value, $this->dateFormat);
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

        return implode("\n", $contents);
    }

    protected function hasModel()
    {
        return $this->model instanceof Model && $this->attribute !== null;
    }

    protected function registerClientOptions($name, $id)
    {
        if ($this->clientOptions !== false) {
            $options = empty($this->clientOptions) ? '' : Json::htmlEncode($this->clientOptions);
            $js = "jQuery('#$id').$name($options);";
            $this->getView()->registerJs($js);
        }
    }

    /**
     * Registers a specific jQuery UI widget events
     * @param string $name the name of the jQuery UI widget
     * @param string $id the ID of the widget
     */
    protected function registerClientEvents($name, $id)
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
    }

    /**
     * Registers a specific jQuery UI widget asset bundle, initializes it with client options and registers related events
     * @param string $name the name of the jQuery UI widget
     * @param string $id the ID of the widget. If null, it will use the `id` value of [[options]].
     */
    protected function registerWidget($name, $id = null)
    {
        if ($id === null) {
            $id = $this->options['id'];
        }
        JuiAsset::register($this->getView());
        $this->registerClientEvents($name, $id);
        $this->registerClientOptions($name, $id);
    }

    public static function getActivFieldOptions($options = [])
    {

        //public $template = "{label}\n{input}\n{hint}\n{error}";

        $widget_options = [
            'template' => '
                <label class="control-label" for="articleform-description">Customize IT!!! Carousel Image ( 1125 x 600 px ):</label> <br />
                <div class="input-group">
                    
                    {input}
                 </div>
                    {hint}
                    {error}'
        ];

        return ArrayHelper::merge($widget_options, $options);

    }
}


/* JUI
<div class="form-group field-carouselform-activate_at_date">
    <label class="control-label" for="carouselform-activate_at_date">Time of activation : </label>
    <div>
    <input type="text" id="carouselform-activate_at_date" name="CarouselForm[activate_at_date]" class="hasDatepicker">
    <p class="help-block help-block-error"></p>
    </div>
</div>
*/
/*
jQuery(function ($) {

    jQuery('#carouselform-activate_at_date').datepicker($.extend({}, $.datepicker.regional['en'], {"dateFormat":"M d, yy"}));

});*/


//DateTimePicker

/*
<div class="form-group">
    <div class='input-group date' id='datetimepicker1'>
        <input type='text' class="form-control" />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
    </div>
</div>
*/

//DateTimePickerAsset::register($this);

/*    $(function () {
    $('#datetimepicker1').datetimepicker();
});*/

/*

<div class="container">
    <div class="row">
        <div class='col-sm-6'>
            <div class="form-group">
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>*/



