<?php
return [

    'language' => 'en-US',
    'timeZone' => 'Europe/Kiev',
    //'timeZone' => 'UTC',
    'supportedLanguages' => [
        'en-US' => 'English',
        'uk-UA' => 'Ukrainian',
        'ru-RU' => 'Russian'
    ],

    'formatters' => [  // used for configure formatter component by selected language

        'en-US' => [
            'dateFormat' => 'php:m/d/Y',
            'timeFormat' => 'php:H:i:s',
            'datetimeFormat' => 'php:m/d/Y H:i:s',
            'currencyCode' => 'USD',
            'locale' => 'en-US',
        ],

        'uk-UA' => [
            'dateFormat' => 'php:d.m.Y',
            'timeFormat' => 'php:H:i:s',
            'datetimeFormat' => 'php:d.m.Y H:i:s',
            'currencyCode' => 'UAN',
            'locale' => 'uk-UA',
        ],

        'ru-RU' => [
            'dateFormat' => 'php:d.m.Y',
            'timeFormat' => 'php:H:i:s',
            'datetimeFormat' => 'php:d.m.Y H:i:s',
            'currencyCode' => 'RUB',
            'locale' => 'ru-RU',
        ],

    ]

];
