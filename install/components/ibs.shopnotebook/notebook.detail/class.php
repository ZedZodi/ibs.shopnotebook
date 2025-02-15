<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Ibs\shopnotebook\NotebookTable;
class LaptopsDetailComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        if (!Loader::includeModule('ibs.notebook')) {
            return;
        }

        $notebookId = $this->arParams['NOTEBOOK_ID'];
        $this->arResult['NOTEBOOK'] = NotebookTable::getById($notebookId)->fetch();

        $this->includeComponentTemplate();
    }
}
