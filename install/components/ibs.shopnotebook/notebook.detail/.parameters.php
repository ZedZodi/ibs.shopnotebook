<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = [
    'PARAMETERS' => [
        'NOTEBOOK_ID' => [
            'NAME' => 'ID ноутбука',
            'TYPE' => 'STRING',
            'DEFAULT' => '={$_REQUEST["NOTEBOOK"]}',
        ],
    ],
];
