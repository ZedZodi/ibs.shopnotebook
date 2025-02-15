<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

global $APPLICATION;

$APPLICATION->IncludeComponent(
    'ibs.shopnotebook:notebook.list',
    '',
    [
        'SEF_FOLDER' => $this->arResult['SEF_FOLDER'],
        'SEF_URL_TEMPLATES' => $this->arResult['SEF_URL_TEMPLATES'],
    ]
);
