<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Webservice
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Exception.php 21/11/2011 10:53:49 leonardo $
 */

/**
 * @see Util_Model_Exception
 */
require_once 'Util/Model/Exception.php';

/**
 * @category Library
 * @package Util
 * @subpackage Webservice
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Webservice_Exception extends Util_Model_Exception
{
	/**
	 * WSDL em branco.
	 */
	const WSDL_EMPTY = -2;
	
	/**
	 * Extensão do soap não carregada.
	 */
	const NO_EXTENSION_LOADED = -3;
}
