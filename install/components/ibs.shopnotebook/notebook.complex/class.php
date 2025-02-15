<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

class NotebookComplexComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        if (!Loader::includeModule('ibs.shopnotebook')) {
            return;
        }

        $this->includeComponentTemplate();
    }
}
