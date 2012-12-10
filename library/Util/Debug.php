<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Debug
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Debug.php 27/10/2010 14:28:08 leonardo $
 */

/**
 * Helpers para debug.
 *
 * @category Library
 * @package Util
 * @subpackage Debug
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Debug
{
	/**
	 * Grava em disco um log de debug.
	 *
	 * @param mixed  $content  Conteúdo a ser enviado para o log.
	 * @param string $level    Nível do erro(info, warn, err).
	 * @param bool   $var_dump Se TRUE então usa "var_dump()" ao invés de "print_r()" para o debug.
	 */
	static function Log($content, $level = 'info', $var_dump = false)
	{
		$file = Zend_Registry::get('log_file');
		if(is_file($file) and is_writable($file)) {
			ob_start();
			if($var_dump === true) {
				ini_set('html_errors', 'Off');
				var_dump($content);
			} else {
				print_r($content);
			}
			Zend_Registry::get('log')->{$level}(ob_get_contents());
			ob_end_clean();
		}
	}
}
