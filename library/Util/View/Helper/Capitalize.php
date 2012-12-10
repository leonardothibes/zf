<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Capitalize.php 23/09/2010 16:27:11 leonardo $
 */

/**
 * Helper Capitalize.
 *
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_View_Helper_Capitalize extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * Deixa a primeira letra de uma string maiúscula.
	 *
	 * @param  string $string String a ser convertida.
	 * @return string
	 */
	public function Capitalize($string = null)
	{
		return Util_Format_String::Capitalize($string);
	}
}
