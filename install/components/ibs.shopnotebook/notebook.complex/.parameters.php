<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = [
    'PARAMETERS' => [
        "SEF_MODE" => [
            "manufacturer" => [
                "NAME" => 'Cписок производителей',
                "DEFAULT" => "/#SEF_FOLDER#/ ",
            ],
            "model" => [
                "NAME" => 'Cписок моделей производителя',
                "DEFAULT" => "/#SEF_FOLDER#/#BRAND#/",
            ],
            "notebook" => [
                "NAME" => 'Cписок ноутбуков модели',
                "DEFAULT" => "/#SEF_FOLDER#/#BRAND#/#MODEL#/",
            ],
            "deatil" => [
                "NAME" => 'Детальная страница ноутбука',
                "DEFAULT" => "/#SEF_FOLDER#/detail/#NOTEBOOK#/ ",
            ]
        ],
    ],
];
