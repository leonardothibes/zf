<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Ip.php 08/11/2010 09:17:30 leonardo $
 */

/**
 * @see Util_Format_Abstract
 */
require_once 'Util/Format/Abstract.php';

/**
 * Rotinas para tratamento de IP.
 *
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Format_Ip extends Util_Format_Abstract
{
	/**
	 * Expressão regular para teste de IP.
	 * @var string
	 */
	const Regex = '/^[1-9][0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$/';
	
	/**
	 * Testa se é um IP válido.
	 *
	 * @param mixed $data IP a ser verificado.
	 * @return bool
	 */
	static public function isValid($data = null)
	{
		return (bool)preg_match(self::Regex, $data);
	}
}
