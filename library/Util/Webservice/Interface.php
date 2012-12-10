<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Webservice
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Interface.php 21/11/2011 10:55:26 leonardo $
 */

/**
 * Interface padrão para webservices.
 *
 * Esta interface vale tanto para
 * clientes quanto para servidores.
 *
 * @category Library
 * @package Util
 * @subpackage Webservice
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
interface Util_Webservice_Interface
{
	/**
	 * Configura a URL do WSDL do webservice.
	 *
	 * @param string $wsdl URL do WSDL.
	 * @return void
	 */
	public function __construct($wsdl);
	
	/**
	 * Altera a URL do WSDL do webservice.
	 *
	 * @param string $wsdl URL do WSDL.
	 * @return Util_Webservice_Interface
	 */
	public function setWsdl($wsdl = null);
	
	/**
	 * Recupera a URL do WSDL do webservice.
	 * @return string
	 */
	public function getWsdl();
}
