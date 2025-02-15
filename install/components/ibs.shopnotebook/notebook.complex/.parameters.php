<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = [
    'PARAMETERS' => [
        'SEF_FOLDER' => [
            'NAME' => 'Каталог ЧПУ',
            'TYPE' => 'STRING',
            'DEFAULT' => '/notebook/',
        ],
        'SEF_MODE' => [
            'NAME' => 'Включить ЧПУ',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],
        'SEF_URL_TEMPLATES' => [
            'brands' => '',
            'models' => '#BRAND#/',
            'laptops' => '#BRAND#/#MODEL#/',
            'detail' => 'detail/#NOTEBOOK#/',
        ],
    ],
];
