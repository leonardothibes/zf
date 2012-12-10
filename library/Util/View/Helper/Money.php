<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Money.php 23/11/2010 16:46:24 leonardo $
 */

/**
 * Helper Money.
 *
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_View_Helper_Money extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * Converte un número em valor monetário para exibir na tela.
	 *
	 * @param float|int $number Número a ser convertido.
	 * @param string    $format Formato da moeda.
	 *
	 * @return string
	 */
	public function Money($number = null, $format = Util_Format_Number::REAL)
	{
		return Util_Format_Number::toMoney($number, $format);
	}
}
