<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Css.php 29/11/2010 08:48:12 leonardo $
 */

/**
 * Helper Css.
 *
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_View_Helper_Css extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * Inclui um Css no header do HTML.
	 *
	 * @param array $files Caminho do(s) Css(s) a ser(em) carregado(s).
	 * @return string
	 */
	public function Css($files = array())
	{
		$tags = null;
		
		foreach((array)$files as $file) {
			$tags .= sprintf('<link type="text/css" href="%s" rel="stylesheet" />', $file);
		}
		
		return $tags;
	}
}
