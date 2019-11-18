<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use \Bitrix\Main\Application;
use \Maxidom\Map\DataTable;

if (!CModule::IncludeModule("maxidom.map")) {
    die();
}

$request = Application::getInstance()->getContext()->getRequest();

$result = DataTable::update(1, array(
    'DATA' => $request->getPost('data'),
    'CENTER' => $request->getPost('center'),
    'ZOOM' => $request->getPost('zoom')
));
?>