<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Xml.php 03/11/2010 14:44:44 leonardo $
 */

/**
 * @see Util_Format_Abstract
 */
require_once 'Util/Format/Abstract.php';

/**
 * Rotinas para tratamento de XML.
 *
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Format_Xml extends Util_Format_Abstract
{
	/**
	 * Testa se é um XML válido.
	 *
	 * @param mixed $data Dado a ser verificado.
	 * @return bool
	 */
	static public function isValid($data = null)
	{
		$xml = @simplexml_load_string($data);
		return ($xml instanceof SimpleXMLElement);
	}
	
	/**
	 * Converte uma string XML num array.
	 *
	 * @param SimpleXMLElement|string $xml XML a ser convertido.
	 * @return array
	 */
	static public function toArray($xml)
	{
		if(is_array($xml)) {
			$array = $xml;
		} else {
			$array = simplexml_load_string($xml);
		}
		
		$newArray = array();
		$idx      = (int)0;
		foreach($array as $key => $value) {
			$value = (array)$value;
			$key   = ($key == 'row') ? $key . ++$idx : $key;
			if(isset($value[0])) {
				$newArray[$key] = trim($value[0]);
			} else {
				$newArray[$key] = (is_array($value) and count($value) == 0) ? null : self::toArray($value);
			}
		}
		
		return $newArray;
	}
}
