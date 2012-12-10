<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: CreditCard.php 20/10/2010 17:08:23 leonardo $
 */

/**
 * @see Util_Format_Abstract
 */
require_once 'Util/Format/Abstract.php';

/**
 * Rotinas para tratamento de cartão de crédito.
 *
 * Esta classe não deve ser usada com cartões de crédito
 * American Express pois ele tem uma máscara diferente.
 *
 * Quando se quiser testar cartões American Express,
 * deve-se usar a classe "Util_Form_CreditCardAmex".
 *
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Format_CreditCard extends Util_Format_Abstract
{
	/**
	 * Expressão regular para teste de cartão de crédito.
	 * @var string
	 */
	const Regex = '/^[0-9]{4}\s[0-9]{4}\s[0-9]{4}\s[0-9]{4}$/';
	
	/**
	 * Testa se é um cartão de crédito válido.
	 *
	 * @param mixed $data E-mail a ser verificado.
	 * @param bool  $amex Se ativado então tenda casar com Amex também.
	 *
	 * @return bool
	 */
	static public function isValid($data = null, $amex = false)
	{
		if(preg_match(self::Regex, $data)) {
			return true;
		} else if($amex) {
			/** @see Util_Format_CreditCardAmex **/
			require_once 'Util/Format/CreditCardAmex.php';
			return Util_Format_CreditCardAmex::isValid($data);
		}
		
		return false;
	}
	
	/**
	 * Inclui uma máscara.
	 *
	 * @param mixed $data Cartão a ser mascarado.
	 * @return string|null
	 */
	static public function Mask($data)
	{
		return substr($data, 0, 4) . ' ' .
		       substr($data, 4, 4) . ' ' .
		       substr($data, 8, 4) . ' ' .
		       substr($data, 12, 4);
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
