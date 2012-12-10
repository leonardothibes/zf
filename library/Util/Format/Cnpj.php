<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Cnpj.php 14/07/2011 16:18:53 leonardo $
 */

/**
 * @see Util_Format_Abstract
 */
require_once 'Util/Format/Abstract.php';

/**
 * Rotinas para tratamento de CNPJ.
 *
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Format_Cnpj extends Util_Format_Abstract
{
	/**
	 * Expressão regular para teste de Cnpj.
	 * @var string
	 */
	const Regex = '/^[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2}$/';
	
	/**
	 * Testa se é um CNPJ válido.
	 *
	 * @param mixed $data Cnpj a ser verificado.
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
		return (string)(
			substr($data, 0, 2) . '.' .
			substr($data, 2, 3) . '.' .
			substr($data, 5, 3) . '/' .
			substr($data, 8, 4) . '-' .
			substr($data, 12, 14)
		);
	}
	
	/**
	 * Retira a máscara.
	 *
	 * @param string Cep a ter sua máscara retirada.
	 * @return mixed
	 */
	static public function UnMask($data)
	{
		return str_replace(array('.', '/', '-'), '', trim($data));
	}
}
