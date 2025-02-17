<?

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

// проверка идентификатора сессии
if (!check_bitrix_sessid()) {
    return;
}

// метод возвращает объект класса CApplicationException, содержащий последнее исключение
if ($errorException = $APPLICATION->getException()) {
    // вывод сообщения об ошибке при удалении модуля
    CAdminMessage::showMessage(
        Loc::getMessage('DEINSTALL_FAILED') . ': ' . $errorException->GetString()
    );
} else {
    // вывод уведомления при успешном удалении модуля
    CAdminMessage::showNote(
        Loc::getMessage('DEINSTALL_SUCCESS')
    );
}
?>

<form action="<?= $APPLICATION->GetCurPage() ?>">
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="submit" name="" value="<?= Loc::getMessage("MOD_BACK") ?>">
</form>
