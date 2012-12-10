<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Xml
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Exception.php 22/12/2011 10:06:47 leonardo $
 */

/**
 * @see Zend_Exception
 */
require_once 'Zend/Exception.php';

/**
 * @category Library
 * @package Util
 * @subpackage Xml
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Xml_Exception extends Zend_Exception
{
	/**
	 * Código de erro para XML mal formado.
	 * @var int
	 */
	const BAD_XML = -1;
	
	/**
	 * Código de erro para XML não encontrado no disco.
	 * @var int
	 */
	const NOT_FOUND = -2;
}
