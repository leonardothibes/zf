<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: BasePath.php 20/04/2011 15:48:11 leonardo $
 */

/**
 * Helper Static
 *
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_View_Helper_BasePath extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * Converte caminho relativo em caminho absoluto.
	 *
	 * @param string $file Caminho relativo para o arquivo.
	 * @param bool   $force Força a utilização da conversão.
	 *
	 * @return string Caminho absoluto.
	 */
	public function BasePath($file, $force = false)
	{
		return Util_Helper::BasePath($file, $force);
	}
}
