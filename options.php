<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

// пространство имен для получения ID модуля

// пространство имен для загрузки необходимых файлов, классов, модулей

// пространство имен для работы с параметрами модулей хранимых в базе данных

Loc::loadMessages(__FILE__);

$request = HttpApplication::getInstance()->getContext()->getRequest();

//Ядро требует именовать $module_id в типе snake_case
$module_id = htmlspecialcharsbx($request["mid"] != "" ? $request["mid"] : $request["id"]);

$postRight = $APPLICATION->GetGroupRight($module_id);

if ($postRight < "S") {
    $APPLICATION->AuthForm(Loc::getMessage("ACCESS_DENIED"));
}

Loader::includeModule($module_id);

$aTabs = array(
    array(
        "DIV" => "edit2",
        "TAB" => Loc::getMessage("MAIN_TAB_RIGHTS"),
        "TITLE" => Loc::getMessage("MAIN_TAB_TITLE_RIGHTS")
    )
);

if ($request->isPost() && check_bitrix_sessid()) {
    foreach ($aTabs as $aTab) {
        foreach ($aTab["OPTIONS"] as $arOption) {
            if (!is_array($arOption)) {
                continue;
            }
            if ($request["Update"]) {
                $optionValue = $request->getPost($arOption[0]);
                if ($arOption[0] == "hmarketing_checkbox") {
                    if ($optionValue == "") {
                        $optionValue = "N";
                    }
                }
                Option::set(
                    $module_id,
                    $arOption[0],
                    is_array($optionValue) ? implode(",", $optionValue) : $optionValue
                );
            }
            if ($request["default"]) {
                Option::set($module_id, $arOption[0], $arOption[2]);
            }
        }
    }
}

$tabControl = new CAdminTabControl(
    "tabControl",
    $aTabs
);

$tabControl->Begin();
?>

    <form action="<?= ($APPLICATION->GetCurPage()); ?>?mid=<?= ($module_id); ?>&lang=<?= (LANG); ?>" method="post">
        <?php
        foreach ($aTabs as $aTab) {
            if ($aTab["OPTIONS"]) {
                $tabControl->BeginNextTab();
                __AdmSettingsDrawList($module_id, $aTab["OPTIONS"]);
            }
        }
        $tabControl->BeginNextTab();
        require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/admin/group_rights.php";
        $tabControl->Buttons();
        echo(bitrix_sessid_post());
        ?>
        <input class="adm-btn-save" type="submit" name="Update" value="Применить"/>
        <input type="submit" name="default" value="По умолчанию"/>
    </form>
<?php
$tabControl->End();
