<?
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Application;
use \Bitrix\Main\Entity\Base;
use \Bitrix\Main\Loader;
use \Bitrix\Main\EventManager;

use \Ibs\shopnotebook\ManufacturerTable;
use \Ibs\shopnotebook\ModelTable;
use \Ibs\shopnotebook\NotebookTable;
use \Ibs\shopnotebook\OptionTable;

Loc::loadMessages(__FILE__);

class Ibs_shopnotebook extends CModule
{
    // переменные модуля
    public  $MODULE_ID;
    public  $MODULE_VERSION;
    public  $MODULE_VERSION_DATE;
    public  $MODULE_NAME;
    public  $MODULE_DESCRIPTION;
    public  $PARTNER_NAME;
    public  $PARTNER_URI;
    public  $SHOW_SUPER_ADMIN_GROUP_RIGHTS;
    public  $MODULE_GROUP_RIGHTS;
    public  $errors;

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
//                $this->addData();
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
        if(Loader::includeModule($this->MODULE_ID)){
            if (!Application::getConnection(ManufacturerTable::getConnectionName())->isTableExists(Base::getInstance("\Ibs\shopnotebook\ManufacturerTable")->getDBTableName())) {
                Base::getInstance("\Ibs\shopnotebook\ManufacturerTable")->createDbTable();
            }

            if (!Application::getConnection(ModelTable::getConnectionName())->isTableExists(Base::getInstance("\Ibs\shopnotebook\ModelTable")->getDBTableName())) {
                Base::getInstance("\Ibs\shopnotebook\ModelTable")->createDbTable();
            }

            if (!Application::getConnection(NotebookTable::getConnectionName())->isTableExists(Base::getInstance("\Ibs\shopnotebook\NotebookTable")->getDBTableName())) {
                Base::getInstance("\Ibs\shopnotebook\NotebookTable")->createDbTable();
            }

            if (!Application::getConnection(OptionTable::getConnectionName())->isTableExists(Base::getInstance("\Ibs\shopnotebook\OptionTable")->getDBTableName())) {
                Base::getInstance("\Ibs\shopnotebook\OptionTable")->createDbTable();
            }
        }
    }

    function UnInstallDB()
    {
        if (Loader::includeModule($this->MODULE_ID)) {
            $connection = Application::getConnection();
            if ($connection->isTableExists(ManufacturerTable::getTableName()))
            {
                $connection->dropTable(ManufacturerTable::getTableName());
            }
            if ($connection->isTableExists(ModelTable::getTableName()))
            {
                $connection->dropTable(ModelTable::getTableName());
            }
            if ($connection->isTableExists(NotebookTable::getTableName()))
            {
                $connection->dropTable(NotebookTable::getTableName());
            }
            if ($connection->isTableExists(OptionTable::getTableName()))
            {
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
        Loader::includeModule($this->MODULE_ID);

        // добавляем запись в таблицу БД
        \Ibs\shopnotebook\DataTable::add(
            array(
                "ACTIVE" => "N",
                "SITE" => '["s1"]',
                "LINK" => " ",
                "LINK_PICTURE" => "/bitrix/components/ibs.shopnotebook/popup.baner/templates/.default/img/banner.jpg",
                "ALT_PICTURE" => " ",
                "EXCEPTIONS" => " ",
                "DATE" => new \Bitrix\Main\Type\DateTime(date("d.m.Y H:i:s")),
                "TARGET" =>  "self",
                "AUTHOR_ID" =>  "1",
            )
        );

        \Ibs\shopnotebook\AuthorTable::add(
            array(
                "NAME" => "Иван",
                "LAST_NAME" => "Иванов",
            )
        );

        return true;
    }
}
