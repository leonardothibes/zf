<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: CreditCardAmex.php 20/10/2010 17:23:04 leonardo $
 */

/**
 * @see Util_Format_Abstract
 */
require_once 'Util/Format/Abstract.php';

/**
 * Rotinas para tratamento de cartão de crédito American Express.
 *
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Format_CreditCardAmex extends Util_Format_Abstract
{
	/**
	 * Expressão regular para teste de cartão de crédito American Express.
	 * @var string
	 */
	const Regex = '/^[0-9]{5}\s[0-9]{6}\s[0-9]{4}$/';
	
	/**
	 * Testa se é um Amex válido.
	 *
	 * @param mixed $data Telefone a ser verificado.
	 * @return bool
	 */
	static public function isValid($data = null)
	{
		return (bool)preg_match(self::Regex, $data);
	}
	
	/**
	 * Inclui uma máscara.
	 *
	 * @param mixed $data Cartão a ser mascarado.
	 * @return string
	 */
	static public function Mask($data)
	{
		return substr($data, 0, 5) . ' ' .
		       substr($data, 5, 6) . ' ' .
		       substr($data, 11, 4);
	}
	
	/**
	 * Retira a máscara.
	 *
	 * @param string Cartão a ter sua máscara retirada.
	 * @return mixed
	 */
	static public function UnMask($data)
	{
		return str_replace(' ', '', $data);
	}
}
