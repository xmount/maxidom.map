<?

use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;
use \Maxidom\Map\DataTable;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class ShowMap extends CBitrixComponent
{

    private function _checkModules()
    {
        if (!Loader::includeModule('maxidom.map')) {
            throw new \Exception('Не загружены модули необходимые для работы модуля');
        }
        return true;
    }


    protected function getResult()
    {
        $cache = new CPHPCache;
        $cacheId = "maxidom_map";
        $cacheTime = 3600;

        if ($cache->InitCache($cacheTime, $cacheId, "maxidom-map")) {
            $vars = $cache->GetVars();
            $this->arResult = array_merge($this->arResult, $vars["arResult"]);
            $this->arResult["CACHE"] = "Y";
        } else {
            $arData = DataTable::getList();
            $this->arResult = $arData->fetch();
            $cache->StartDataCache();
            $cache->EndDataCache(array('arResult' => $this->arResult));
            $this->arResult["CACHE"] = "N";
        }

    }

    public function executeComponent()
    {
        $this->_checkModules();
        $this->getResult();
        $this->includeComponentTemplate();
    }
}

?>