<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Truncate.php 23/09/2010 16:29:49 leonardo $
 */

/**
 * Helper Truncate.
 *
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_View_Helper_Truncate extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * Trunca uma string em um determinado limite.
	 *
	 * @param string $string String a ser truncada.
	 * @param int    $limit  Limite de caracteres que a string deve ter.
	 * @param string $char   Caracter(es) de substituíção.
	 *
	 * @return string
	 */
	public function Truncate($string = null, $limit = 32, $char = '&hellip;')
	{
		return Util_Format_String::Truncate($string, $limit, $char);
	}
}
