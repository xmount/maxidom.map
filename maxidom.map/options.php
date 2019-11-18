<?

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Page\Asset;

Loc::loadMessages(__FILE__);
$request = HttpApplication::getInstance()->getContext()->getRequest();
$module_id = htmlspecialcharsbx($request["mid"] != "" ? $request["mid"] : $request["id"]);
Loader::includeModule($module_id);
?>
<? Asset::getInstance()->addCss('/bitrix/css/' . $module_id . '/style.css'); ?>
    <script src="https://api-maps.yandex.ru/2.1/?load=package.full&lang=ru_RU" type="text/javascript"></script>
<? if (Option::get($module_id, 'jquery_on', 'N') == 'Y') {
    \CJSCore::init(array('jquery'));
} ?>
<? Asset::getInstance()->addJs('/bitrix/js/' . $module_id . '/map_preview.js'); ?>
    <link href="/bitrix/css/maxidom.map/style.css" type="text/css" rel="stylesheet"/>
<?

$aTabs = array(
    array(
        "DIV" => "edit1",
        "TAB" => Loc::getMessage("MX_MP_OPTIONS_TAB1_NAME"),
        "TITLE" => Loc::getMessage("MX_MP_OPTIONS_TAB1_TITLE"),
        'OPTIONS' => array(array(
            'jquery_on',
            Loc::getMessage('MX_MP_JQUERY_ON'),
            'N',                                           // значение по умолчанию «нет»
            array('checkbox')
        )),
    ),
);
$tabControl = new CAdminTabControl(
    "tabControl",
    $aTabs
);

$tabControl->Begin();
$tabControl->BeginNextTab();
?>

    <form method="post"
          action="<? echo $APPLICATION->GetCurPage() ?>?mid=<?= htmlspecialchars($mid) ?>&amp;lang=<? echo LANG ?>&amp;mid_menu=1">
        <?= bitrix_sessid_post(); ?>
        <? __AdmSettingsDrawList($module_id, $aTabs[0]["OPTIONS"]); ?>
        <span class="map_button" id="startDrawing">Включить режим редактирования</span>
        <span class="map_button" id="stopDrawing">Остановить режим редактирования</span>
        <span class="map_button" id="EditSetting">Отредактировать цвета и названия</span>
        <div class="mx_mp_settings"></div>
        <div id="mx_mp_ya_map_preview"></div>

        <? $tabControl->Buttons(); ?>
        <input type="submit" name="apply" value="<? echo(Loc::GetMessage("MX_MP_OPTIONS_INPUT_APPLY")); ?>"
               class="adm-btn-save"/>
    </form>

    <script>
        BX.message({
            MODULE_ID: "<?=$module_id?>"
        });
    </script>
<?
$tabControl->End();

/* Обработка данных */

if ($request->isPost() && check_bitrix_sessid()) {
    foreach ($aTabs as $aTab) {
        foreach ($aTab['OPTIONS'] as $arOption) {
            if (!is_array($arOption)) { // если это название секции
                continue;
            }
            if ($request['apply']) { // сохраняем введенные настройки
                $optionValue = $request->getPost($arOption[0]);
                if ($arOption[0] == 'jquery_on') {
                    if ($optionValue == '') {
                        $optionValue = 'N';
                    }
                }
                Option::set($module_id, $arOption[0], is_array($optionValue) ? implode(',', $optionValue) : $optionValue);

            } elseif ($request['default']) { // устанавливаем по умолчанию
                Option::set($module_id, $arOption[0], $arOption[2]);
            }
        }
    }
    LocalRedirect($APPLICATION->getCurPage() . '?mid=' . $module_id . '&lang=' . LANGUAGE_ID);
}