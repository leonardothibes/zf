<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Js.php 24/11/2010 09:47:39 leonardo $
 */

/**
 * Helper Js.
 *
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_View_Helper_Js extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * Inclui um JavaScript no header do HTML.
	 *
	 * @param array $files Caminho do(s) JavaScript(s) a ser(em) carregado(s).
	 * @return string
	 */
	public function Js($files = array())
	{
		$tags = null;
		
		foreach((array)$files as $file) {
			$tags .= sprintf('<script type="text/javascript" src="%s"></script>', $file);
		}
		
		return $tags;
	}
}
