<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Email.php 20/10/2010 16:09:54 leonardo $
 */

/**
 * @see Util_Format_Abstract
 */
require_once 'Util/Format/Abstract.php';

/**
 * Rotinas para tratamento de e-mail.
 *
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Format_Email extends Util_Format_Abstract
{
	/**
	 * Expressão regular para teste de E-mail.
	 * @var string
	 */
	const Regex = '/^((\"[^\"\f\n\r\t\v\b]+\")|([\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+(\.[\w\!\#\$\%\&\'\*\+\-\~\/\^\`\|\{\}]+)*))@((\[(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))\])|(((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9]))\.((25[0-5])|(2[0-4][0-9])|([0-1]?[0-9]?[0-9])))|((([A-Za-z0-9\-])+\.)+[A-Za-z\-]+))$/';
	
	/**
	 * Testa se é um e-mail válido.
	 *
	 * @param mixed $data E-mail a ser verificado.
	 * @return bool
	 */
	static public function isValid($data = null)
	{
		return (bool)preg_match(self::Regex, $data);
	}
	
	/**
	 * Limpa todo conteúdo inesperado para um e-mail.
	 *
	 * @param mixed $data E-mail a ser limpo.
	 * @return string
	 */
	static public function Sanitize($data)
	{
		return filter_var($data, FILTER_SANITIZE_EMAIL);
	}
}
