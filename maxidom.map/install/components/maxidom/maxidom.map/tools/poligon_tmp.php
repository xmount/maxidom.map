<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use \Bitrix\Main\Application;
use \Maxidom\Map\DataTable;

if (!CModule::IncludeModule("maxidom.map")) {
    die();
}

$arData = DataTable::getList();
$data = $arData->fetch();
dump(json_decode($data["DATA"]));
