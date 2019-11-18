<?

IncludeModuleLangFile(__FILE__);

use \Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;
use Bitrix\Main\Config\Option;

Class maxidom_map extends CModule
{
    var $MODULE_ID = "maxidom.map";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $errors;

    function __construct()
    {
        if (file_exists(__DIR__ . "/version.php")) {
            $arModuleVersion = array();
            include(__DIR__ . "/version.php");

            $this->MODULE_ID = str_replace("_", ".", get_class($this));
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
            $this->MODULE_NAME = Loc::getMessage("MX_MP_INSTALL_NAME");
            $this->MODULE_DESCRIPTION = Loc::getMessage("MX_MP_INSTALL_DESCRIPTION");
            $this->PARTNER_NAME = Loc::getMessage("MX_MP_PARTNER_NAME");
            $this->PARTNER_URI = Loc::getMessage("MX_MP_PARTNER_URI");
        }
        return false;
    }

    function DoInstall()
    {
        $this->InstallDB();
        $this->InstallEvents();
        $this->InstallFiles();
        RegisterModule("maxidom.map");
        return true;
    }

    function DoUninstall()
    {
        $this->UnInstallDB();
        $this->UnInstallEvents();
        $this->UnInstallFiles();
        UnRegisterModule("maxidom.map");
        return true;
    }

    function InstallDB()
    {
        global $DB;
        $this->errors = false;
        $this->errors = $DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/maxidom.map/install/db/install.sql");
        if (!$this->errors) {

            return true;
        } else
            return $this->errors;
    }

    function UnInstallDB()
    {
        global $DB;
        $this->errors = false;
        $this->errors = $DB->RunSQLBatch($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/maxidom.map/install/db/uninstall.sql");
        if (!$this->errors) {
            return true;
        } else
            return $this->errors;
    }

    function InstallEvents()
    {
        return true;
    }

    function UnInstallEvents()
    {
        return true;
    }

    function InstallFiles()
    {
        CopyDirFiles(
            __DIR__ . '/css/' . $this->MODULE_ID,
            Application::getDocumentRoot() . '/bitrix/css/' . $this->MODULE_ID . '/',
            true,
            true
        );

        CopyDirFiles(
            __DIR__ . '/js/' . $this->MODULE_ID,
            Application::getDocumentRoot() . '/bitrix/js/' . $this->MODULE_ID . '/',
            true,
            true
        );
        CopyDirFiles(
            __DIR__ . '/components/maxidom',
            Application::getDocumentRoot() . '/bitrix/components/maxidom/',
            true,
            true
        );

    }

    function UnInstallFiles()
    {
        Directory::deleteDirectory(
            Application::getDocumentRoot() . '/bitrix/js/' . $this->MODULE_ID
        );
        Directory::deleteDirectory(
            Application::getDocumentRoot() . '/bitrix/css/' . $this->MODULE_ID
        );
        Directory::deleteDirectory(
            Application::getDocumentRoot() . '/bitrix/components/maxidom'
        );
        Option::delete($this->MODULE_ID);
    }

}
?>