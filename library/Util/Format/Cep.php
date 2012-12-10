<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Cep.php 20/10/2010 15:54:57 leonardo $
 */

/**
 * @see Util_Format_Abstract
 */
require_once 'Util/Format/Abstract.php';

/**
 * Rotinas para tratamento de CEP.
 *
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Format_Cep extends Util_Format_Abstract
{
	/**
	 * Expressão regular para teste de CEP.
	 * @var string
	 */
	const Regex = '/^[0-9]{5}\-[0-9]{3}$/';
	
	/**
	 * Testa se é um CEP válido.
	 *
	 * @param mixed $data Cep a ser verificado.
	 * @return bool
	 */
	static public function isValid($data = null)
	{
		return (bool)preg_match(self::Regex, $data);
	}
	
	/**
	 * Inclui uma máscara.
	 *
	 * @param mixed $data Cep a ser mascarado.
	 * @return string
	 */
	static public function Mask($data)
	{
		$data = trim($data);
		return (string)substr($data, 0, 5) . '-' . substr($data, 5, 7);
	}
	
	/**
	 * Retira a máscara.
	 *
	 * @param string Cep a ter sua máscara retirada.
	 * @return mixed
	 */
	static public function UnMask($data)
	{
		return str_replace('-', '', trim($data));
	}
}
