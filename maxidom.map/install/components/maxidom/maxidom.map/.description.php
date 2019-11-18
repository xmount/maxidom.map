<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

$arComponentDescription = [
    "NAME" => Loc::getMessage("MX_NAME"),
    "DESCRIPTION" => Loc::getMessage("MX_DESCRIPTION"),
    "COMPLEX" => "N",
    "PATH" => [
        "ID" => Loc::getMessage("MX_PATH_ID"),
        "NAME" => Loc::getMessage("MX_PATH_NAME"),
    ],
];
?>
