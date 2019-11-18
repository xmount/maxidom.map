<?

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

CJSCore::Init(array("jquery"));
Asset::getInstance()->addJs("https://api-maps.yandex.ru/2.1/?load=package.full&lang=ru_RU");
echo ($arResult["CACHE"] == "Y") ? Loc::getMessage('CACHE') : Loc::getMessage('NOCACHE');
?>


<div id="mx_mp_ya_map_preview"></div>

<script>
    BX.message({
        DATA: <?=$arResult["DATA"]?>,
        CENTER: <?=$arResult["CENTER"]?>,
        ZOOM: <?=$arResult["ZOOM"]?>

    });
</script>
