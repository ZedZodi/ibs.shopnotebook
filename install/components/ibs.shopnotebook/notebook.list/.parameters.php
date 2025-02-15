<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = [
    'PARAMETERS' => [
        'SEF_FOLDER' => [
            'NAME' => 'Каталог ЧПУ',
            'TYPE' => 'STRING',
            'DEFAULT' => '/notebook/',
        ],
        'PAGE_SIZE' => [
            'NAME' => 'Количество элементов на странице',
            'TYPE' => 'STRING',
            'DEFAULT' => '10',
        ],
    ],
];
