<?php

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Ibs\shopnotebook\ManufacturerTable;
use Ibs\shopnotebook\ModelTable;
use Ibs\shopnotebook\NotebookTable;
use Ibs\shopnotebook\OptionTable;

Loc::loadMessages(__FILE__);

class Ibs_shopnotebook extends CModule
{
    // переменные модуля
    public $MODULE_ID;
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $PARTNER_NAME;
    public $PARTNER_URI;
    public $SHOW_SUPER_ADMIN_GROUP_RIGHTS;
    public $MODULE_GROUP_RIGHTS;
    public $errors;

    function __construct()
    {
        $arModuleVersion = array();
        include_once(__DIR__ . '/version.php');

        // версия модуля
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        // дата релиза версии модуля
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        // id модуля
        $this->MODULE_ID = "ibs.shopnotebook";
        // название модуля
        $this->MODULE_NAME = "Модуль “Магазин ноутбуков”";
        // описание модуля
        $this->MODULE_DESCRIPTION = "Тестовое задание для IBS";
        // имя партнера выпустившего модуль
        $this->PARTNER_NAME = "IBS";
        // ссылка на рисурс партнера выпустившего модуль
        $this->PARTNER_URI = "https://ibs.ru";
        // если указано, то на странице прав доступа будут показаны администраторы и группы
        $this->SHOW_SUPER_ADMIN_GROUP_RIGHTS = 'Y';
        // если указано, то на странице редактирования групп будет отображаться этот модуль
        $this->MODULE_GROUP_RIGHTS = 'Y';
    }

    function DoInstall()
    {
        $context = Application::getInstance()->getContext();
        $request = $context->getRequest();
        global $APPLICATION;
        if ($request["step"] < 2) {
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage('INSTALL_TITLE_STEP_1'),
                __DIR__ . '/instalInfo-step1.php'
            );
        }
        if ($request["step"] == 2) {
            ModuleManager::RegisterModule("ibs.shopnotebook");
            $this->InstallDB();
            $this->InstallEvents();
            $this->InstallFiles();
            if ($request["add_data"] == "Y") {
                // создаем первую и единственную запись в БД
                $this->addData();
            }
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage('INSTALL_TITLE_STEP_2'),
                __DIR__ . '/instalInfo-step2.php'
            );
        }

        return true;
    }

    function DoUninstall()
    {
        $context = Application::getInstance()->getContext();
        $request = $context->getRequest();
        global $APPLICATION;
        if ($request["step"] < 2) {
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage('DEINSTALL_TITLE_1'),
                __DIR__ . '/deInstalInfo-step1.php'
            );
        }
        if ($request["step"] == 2) {
            if ($request["save_data"] == "Y") {
                $this->UnInstallDB();
            }

            ModuleManager::UnRegisterModule("ibs.shopnotebook");
            $APPLICATION->IncludeAdminFile(
                Loc::getMessage('DEINSTALL_TITLE_2'),
                __DIR__ . '/deInstalInfo-step2.php'
            );
        }
        return true;
    }

    function InstallDB()
    {
        // подключаем модуль для того что бы был видем класс ORM
        if (Loader::includeModule($this->MODULE_ID)) {
            if (!Application::getConnection(ManufacturerTable::getConnectionName())->isTableExists(
                Base::getInstance(ManufacturerTable::class)->getDBTableName()
            )) {
                Base::getInstance(ManufacturerTable::class)->createDbTable();
            }

            if (!Application::getConnection(ModelTable::getConnectionName())->isTableExists(
                Base::getInstance(ModelTable::class)->getDBTableName()
            )) {
                Base::getInstance(ModelTable::class)->createDbTable();
            }

            if (!Application::getConnection(NotebookTable::getConnectionName())->isTableExists(
                Base::getInstance(NotebookTable::class)->getDBTableName()
            )) {
                Base::getInstance(NotebookTable::class)->createDbTable();
            }

            if (!Application::getConnection(OptionTable::getConnectionName())->isTableExists(
                Base::getInstance(OptionTable::class)->getDBTableName()
            )) {
                Base::getInstance(OptionTable::class)->createDbTable();
            }
        }
    }

    function UnInstallDB()
    {
        if (Loader::includeModule($this->MODULE_ID)) {
            $connection = Application::getConnection();
            if ($connection->isTableExists(ManufacturerTable::getTableName())) {
                $connection->dropTable(ManufacturerTable::getTableName());
            }
            if ($connection->isTableExists(ModelTable::getTableName())) {
                $connection->dropTable(ModelTable::getTableName());
            }
            if ($connection->isTableExists(NotebookTable::getTableName())) {
                $connection->dropTable(NotebookTable::getTableName());
            }
            if ($connection->isTableExists(OptionTable::getTableName())) {
                $connection->dropTable(OptionTable::getTableName());
            }
        }

        Option::delete($this->MODULE_ID);
    }

    function InstallFiles()
    {
        CopyDirFiles(
            __DIR__ . "/admin",
            $_SERVER["DOCUMENT_ROOT"] . "/bitrix/admin",
            true,
            true
        );

        CopyDirFiles(
            __DIR__ . "/components",
            $_SERVER["DOCUMENT_ROOT"] . "/local/components",
            true,
            true
        );

        CopyDirFiles(
            __DIR__ . '/files',
            $_SERVER["DOCUMENT_ROOT"] . '/',
            true,
            true
        );

        return true;
    }

    function addData()
    {
        if (Loader::includeModule($this->MODULE_ID)) {
            $manufacturers = [
                ['NAME' => 'Apple'],
                ['NAME' => 'Dell'],
                ['NAME' => 'HP'],
                ['NAME' => 'Lenovo'],
                ['NAME' => 'Asus'],
            ];

            foreach ($manufacturers as $manufacturer) {
                ManufacturerTable::add($manufacturer);
            }

            $models = [
                ['NAME' => 'MacBook Pro', 'MANUFACTURER_ID' => 1],
                ['NAME' => 'XPS 13', 'MANUFACTURER_ID' => 2],
                ['NAME' => 'Spectre x360', 'MANUFACTURER_ID' => 3],
                ['NAME' => 'ThinkPad X1', 'MANUFACTURER_ID' => 4],
                ['NAME' => 'ZenBook Pro', 'MANUFACTURER_ID' => 5],
            ];

            foreach ($models as $model) {
                ModelTable::add($model);
            }

            $notebooks = [
                ['NAME' => 'MacBook Pro 16"', 'YEAR' => 2023, 'PRICE' => 2500.00, 'MODEL_ID' => 1],
                ['NAME' => 'Dell XPS 13 9310', 'YEAR' => 2022, 'PRICE' => 1500.00, 'MODEL_ID' => 2],
                ['NAME' => 'HP Spectre x360 14', 'YEAR' => 2023, 'PRICE' => 1800.00, 'MODEL_ID' => 3],
                ['NAME' => 'Lenovo ThinkPad X1 Carbon', 'YEAR' => 2023, 'PRICE' => 2000.00, 'MODEL_ID' => 4],
                ['NAME' => 'Asus ZenBook Pro Duo', 'YEAR' => 2023, 'PRICE' => 2200.00, 'MODEL_ID' => 5],
            ];

            foreach ($notebooks as $notebook) {
                NotebookTable::add($notebook);
            }

            $options = [
                ['NAME' => '16GB RAM', 'NOTEBOOK_ID' => 1],
                ['NAME' => '1TB SSD', 'NOTEBOOK_ID' => 1],
                ['NAME' => '4K Display', 'NOTEBOOK_ID' => 2],
                ['NAME' => 'Touchscreen', 'NOTEBOOK_ID' => 3],
                ['NAME' => 'Backlit Keyboard', 'NOTEBOOK_ID' => 4],
            ];

            foreach ($options as $option) {
                OptionTable::add($option);
            }

            echo "Данные успешно добавлены!";
        }

        return true;
    }
}
