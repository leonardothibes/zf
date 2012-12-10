<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Exception.php 19/06/2012 15:44:19 leonardo $
 */

/**
 * @see Zend_Exception
 */
require_once 'Zend/Exception.php';

/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Payment_Exception extends Zend_Exception
{
	/**
	 * Adapter inválido.
	 */
	const INVALID_ADAPTER = -1;
}
