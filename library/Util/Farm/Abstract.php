<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Farm
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Abstract.php 27/08/2012 16:06:57 leonardo $
 */

/**
 * @see Util_Model_Abstract
 */
require_once 'Util/Model/Abstract.php';

/**
 * @category Library
 * @package Util
 * @subpackage Farm
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
abstract class Util_Farm_Abstract extends Util_Model_Abstract
{
	/**
	 * Construtor.
	 */
	public function __construct()
	{
		//Configurando driver de cache.
		$cache = Zend_Registry::get('config')->cache;
		if($cache->enable and extension_loaded($cache->driver)) {
			$this->_cacheEnabled = true;
			$this->_driver       = $cache->driver;
		}
		$opts = array(
			'servers'     => array(),
			'compression' => true
		);
		$farm = Util_Farm_Server::ListNodes();
		foreach($farm as $host) {
			$opts['servers'][] = array(
				'host'   => $host,
				'port'   => $cache->port,
				'weight' => 1
			);
		}
		$this->setCacheDriver($this->_driver, $opts);
		//Configurando driver de cache.
		
		//Front-end de procedures.
		$this->procedure = new Util_Db_Proc();
		
		//Front-end para os flitros do ZF.
		$this->filter = new Util_Model_Filter();
		
		//Configurando as classes filhas.
		$this->init();
	}
}
