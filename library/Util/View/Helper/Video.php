<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Video.php 07/10/2010 14:10:58 leonardo $
 */

/**
 * Helper Vídeo.
 *
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_View_Helper_Video extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * Caminho para o player.
	 * @var string
	 */
	private $_player = '/swf/player.swf';
	
	/**
	 * Insere um vídeo em Flash na página.
	 *
	 * @param string $video     Caminho web para o vídeo.
	 * @param int    $width     Largura do vídeo na tela.
	 * @param int    $height    Altura do vídeo na tela.
	 * @param bool   $autostart Se ativado executa ao carregar a página.
	 * @param string $bgcolor   Cor de fundo da tag Flash.
	 *
	 * @return string HTML do vídeo.
	 */
	public function Video($video = null, $width = 666, $height = 400, $autostart = true, $bgcolor = '#000000')
	{
		if(!strlen($video)) {
			return null;
		}
		
		$flashvars  = sprintf('file=:VIDEO'               , (string)$video);
		$flashvars .= sprintf('&amp;width=:WIDTH'         , (int)$width);
		$flashvars .= sprintf('&amp;height=:HEIGHT'       , (int)$height);
		$flashvars .= sprintf('&amp;autostart=:AUTOSTART' , (bool)$autostart);
		$flashvars .= '&amp;fullscreenmode=false&amp;showdigits=true&amp;showfsbutton=false&amp;repeat=false&amp;bufferlength=30&amp;overstretch=fit';
		
		$autostart = $autostart ? 'true' : 'false';
		$bgcolor   = substr($bgcolor, 0, 1) == '#' ? $bgcolor : '#' . $bgcolor;
		
		$tag = '<object width=":WIDTH" height=":HEIGHT" type="application/x-shockwave-flash" data=":PLAYER">
			<param name="movie" value=":PLAYER" />
			<param name="type" value="video" />
			<param name="quality" value="high" />
			<param name="allowfullscreen" value="true" />
			<param name="allowscriptaccess" value="always" />
			<param name="wmode" value="opaque" />
			<param name="bgcolor" value=":BGCOLOR" />
			<param name="flashvars" value="'.$flashvars.'" />
		</object>';
		
		return strtr($tag, array(
			':VIDEO'     => (string)$video,
			':WIDTH'     => (int)$width,
			':HEIGHT'    => (int)$height,
			':AUTOSTART' => (string)$autostart,
			':BGCOLOR'   => (string)$bgcolor,
			':PLAYER'    => $this->_player
		));
	}
}
