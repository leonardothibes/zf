<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: YouTube.php 25/04/2011 11:42:46 leonardo $
 */

/**
 * Helper YouTube.
 *
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_View_Helper_YouTube extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * Publica na página um vídeo do YouTube.
	 *
	 * @param string $url    URL do vídeo.
	 * @param bool   $auto   Se ativado então o vídeo começa a tocar sozinho.
	 * @param int    $width  Largura do player me pixels.
	 * @param int    $height Altura do player me pixels.
	 *
	 * @return string HTML da chamada do player.
	 */
	public function YouTube($url = null, $auto = false, $width = 425, $height = 344)
	{
		if(!strlen($url)) {
			return null;
		}
		
		if($auto) {
			$url .= '&autoplay=1';
		}
		
		$html = '
			<object width=":WIDTH" height=":HEIGHT">
				<param name="movie" value=":URL"></param>
				<param name="allowFullScreen" value="true"></param>
				<param name="allowscriptaccess" value="always"></param>
				<embed
					src=":URL"
					type="application/x-shockwave-flash"
					allowscriptaccess="always"
					allowfullscreen="true"
					width=":WIDTH"
					height=":HEIGHT"
				>
				</embed>
			</object>
		';
		
		return strtr($html, array(
			':WIDTH'  => (int)$width,
			':HEIGHT' => (int)$height,
			':URL'    => (string)$url
		));
	}
}
