<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Model
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Exception.php 21/11/2011 08:27:16 leonardo $
 */

/**
 * @see Zend_Exception
 */
require_once 'Zend/Exception.php';

/**
 * @category Library
 * @package Util
 * @subpackage Model
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Model_Exception extends Zend_Exception
{
	/**
	 * Filtro não encontrado.
	 * @var int
	 */
	const FILTER_NOT_FOUND = 1;
}
