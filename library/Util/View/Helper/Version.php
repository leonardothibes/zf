<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Version.php 27/11/2012 16:15:59 leonardo $
 */

/**
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_View_Helper_Version extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * Retorna a versão corrente do site.
	 * @return string
	 */
	public function Version()
	{
		return Zend_Registry::get('version');
	}
}
