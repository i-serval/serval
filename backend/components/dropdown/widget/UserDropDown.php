<?php

namespace backend\components\dropdown\widget;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\components\dropdown\widget\UserDropDownAsset;

class UserDropDown extends Widget
{

    public $items = [];
    public $options = [];
    public $route;
    public $params;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }

        if ($this->params === null) {
            $this->params = Yii::$app->request->getQueryParams();
        }

        if (!empty($this->items)) {
            echo Html::tag('div', $this->renderDropDown(), ['id' => 'user-dropdown-menu']);
        }

        UserDropDownAsset::register($this->getView());
    }

    protected function renderDropDown()
    {

        $label = (isset($this->options['label'])) ? $this->options['label'] : '';
        $tag = (isset($this->options['tag'])) ? $this->options['tag'] : 'div';

        unset($this->options['label']);
        unset($this->options['tag']);

        return Html::tag($tag, $label, $this->options) . $this->renderItems();
    }

    protected function renderItems()
    {

        $lines = [];

        foreach ($this->items as $item) {

            $options = ArrayHelper::removeValue($item, 'options', ['class' => 'user-dropdown-menu-item']);

            $url = $item['url'];

            $a_tag_options = [];
            $li_tag_options = ArrayHelper::getValue($item, 'options', ['class' => 'user-dropdown-menu-item']);

            if ($url != '#') {
                $url = Html::encode(Url::to($url));
            }

            $a_tag_options['href'] = $url;
            $a_tag_options['class'] = 'user-dropdown-menu-link';

            $lines[] = Html::tag('li',
                Html::tag('a', $item['label'], $a_tag_options),
                $li_tag_options
            );
        }

        return Html::tag('ul', implode("\n", $lines));

    }

}
