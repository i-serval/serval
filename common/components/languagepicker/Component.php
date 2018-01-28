<?php

namespace common\components\languagepicker;

use Yii;


class Component extends \lajax\languagepicker\Component
{

    public function __construct($config = array())
    {

        parent::__construct($config);

    }

    public function init()
    {

        parent::init();
        $this->initFormatter();

    }

    public function detectLanguage()
    {

        $acceptableLanguages = Yii::$app->getRequest()->getAcceptableLanguages();

        if (isset($acceptableLanguages[0])) { // try convert http header value like 'uk' 'ru' to 'uk-UA' 'ru-RU', so try detect preferred language use yii method

            $acceptableLanguages[0] = Yii::$app->request->getPreferredLanguage(array_keys(Yii::$app->params['i18n']['supportedLanguages']));

        }

        foreach ($acceptableLanguages as $language) {
            if ($this->_isValidLanguage($language)) {
                Yii::$app->language = $language;
                $this->saveLanguageIntoCookie($language);
                return;
            }
        }

        foreach ($acceptableLanguages as $language) {
            $pattern = preg_quote(substr($language, 0, 2), '/');
            foreach ($this->languages as $key => $value) {
                if (preg_match('/^' . $pattern . '/', $value) || preg_match('/^' . $pattern . '/', $key)) {
                    Yii::$app->language = $this->_isValidLanguage($key) ? $key : $value;
                    $this->saveLanguageIntoCookie(Yii::$app->language);
                    return;
                }
            }
        }

    }

    public function getLanguage()
    {

        if (Yii::$app->request->cookies->has($this->cookieName)) {
            if ($this->_isValidLanguage(Yii::$app->request->cookies->getValue($this->cookieName))) {
                return Yii::$app->request->cookies->getValue($this->cookieName);
            } else {
                Yii::$app->response->cookies->remove($this->cookieName);
            }
        }

        return null;

    }

    protected function _redirect()
    {
        $redirect = Yii::$app->request->absoluteUrl == Yii::$app->request->referrer ? '/' : Yii::$app->request->referrer;
        return Yii::$app->response->redirect($redirect);
    }

    protected function _isValidLanguage($language)
    {
        return is_string($language) && (isset($this->languages[$language]) || in_array($language, $this->languages));
    }

    protected function initFormatter()
    {

        $formatter_config = Yii::$app->params['i18n']['formatters'][Yii::$app->language] ?? [];

        foreach ($formatter_config as $property_name => $value) {
            Yii::$app->formatter->{$property_name} = $value;
        }


    }

}
