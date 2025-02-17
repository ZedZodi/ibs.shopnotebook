<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

global $APPLICATION;

$APPLICATION->IncludeComponent(
    'bitrix:main.ui.grid',
    '',
    [
        'GRID_ID' => 'notebook_grid',
        'COLUMNS' => [
            ['id' => 'ID', 'name' => 'ID', 'sort' => 'ID'],
            ['id' => 'NAME', 'name' => 'Название', 'sort' => 'NAME'],
            ['id' => 'YEAR', 'name' => 'Год выпуска', 'sort' => 'YEAR'],
            ['id' => 'PRICE', 'name' => 'Цена', 'sort' => 'PRICE'],
        ],
        'ROWS' => $this->arResult['ITEMS'],
        'NAV_OBJECT' => $this->arResult['NAV_OBJECT'],
    ]
);
