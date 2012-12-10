<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Flash.php 23/09/2010 14:31:37 leonardo $
 */

/**
 * Helper Flash.
 *
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_View_Helper_Flash extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * Insere uma animação em Flash na página.
	 *
	 * @param string $path   Caminho para o arquivo SWF.
	 * @param int    $width  Largura da animação na tela.
	 * @param int    $height Altura da animação na tela.
	 *
	 * @return string HTML da tag de animação.
	 */
	public function Flash($path, $width, $height)
	{
		$tag = '<object type="application/x-shockwave-flash" width="%s" height="%s" data="%s">
			<param name="movie" value="%s" />
			<param name="wmode" value="transparent" />
		</object>';
		
		return sprintf($tag, $width, $height, $path, $path);
	}
}
