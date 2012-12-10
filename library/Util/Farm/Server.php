<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Farm
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Server.php 27/08/2012 11:41:06 leonardo $
 */

/**
 * Classe utilitária para lidar com os nodes da webfarm.
 *
 * @category Library
 * @package Util
 * @subpackage Farm
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Farm_Server
{
	/**
	 * Descobre em qual servidor de aplicação está rodando no momento.
	 * @return string
	 */
	static public function WhoAmi()
	{
		$ip   = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '127.0.0.1';
		$farm = Zend_Registry::get('config')->farm;
		$name = self::WhoIs($ip);
		return $name ? $name : 'localhost';
	}
	
	/**
	 * Descobre o nome do node da webfarm.
	 *
	 * @param string $ip IP do servidor.
	 * @return false|string
	 */
	static public function WhoIs($ip)
	{
		$farm = Zend_Registry::get('config')->farm;
		if(!$farm instanceof Zend_Config) {
			return false;
		}
		foreach($farm as $node) {
			if($node->addr == $ip) {
				return $node->name;
			}
		}
		return false;
	}
	
	/**
	 * Lista os nodes da webfarm.
	 *
	 * @param bool $flag Se ativado então inverte a indexação do array pelos IPs ao invés dos nomes.
	 * @return array
	 */
	static public function ListNodes($flag = false)
	{
		$farm  = Zend_Registry::get('config')->farm;
		$nodes = array();
		foreach($farm as $node) {
			if($flag) {
				$nodes[$node->addr] = $node->name;
			} else {
				$nodes[$node->name] = $node->addr;
			}
		}
		return $nodes;
	}
}
