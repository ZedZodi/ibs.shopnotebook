<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Grid\Options as GridOptions;
use Bitrix\Main\UI\PageNavigation;

class NotebookListComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        if (!Loader::includeModule('ibs.shopnotebook')) {
            return;
        }

        $this->arResult['SEF_FOLDER'] = $this->arParams['SEF_FOLDER'];
        $this->arResult['PAGE_SIZE'] = $this->arParams['PAGE_SIZE'];

        $this->includeComponentTemplate();
    }
}
