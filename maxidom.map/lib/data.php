<?php
namespace Maxidom\Map;
 
use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

/**
 * Class MapTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> DATA string mandatory
 * <li> CENTER string(256) optional
 * <li> ZOOM int optional
 * </ul>
 *
 * @package Bitrix\Map
 **/

class DataTable extends Entity\DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	
	public static function getTableName()
   {
      return 'maxidom_map';
   }
   /**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
   
   public static function getMap()
	{
		return array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'autocomplete' => true,
				'title' => Loc::getMessage('MAP_ENTITY_ID_FIELD'),
			),
			'DATA' => array(
				'data_type' => 'text',
				'required' => true,
				'title' => Loc::getMessage('MAP_ENTITY_DATA_FIELD'),
			),
			'CENTER' => array(
				'data_type' => 'string',
				'title' => Loc::getMessage('MAP_ENTITY_CENTER_FIELD'),
			),
			'ZOOM' => array(
				'data_type' => 'integer',
				'title' => Loc::getMessage('MAP_ENTITY_ZOOM_FIELD'),
			),
		);
	}
	
}