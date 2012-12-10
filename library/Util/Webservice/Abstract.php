<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Webservice
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Abstract.php 01/12/2011 14:23:09 leonardo $
 */

/**
 * @see Util_Model_Abstract
 */
require_once 'Util/Model/Abstract.php';

/**
 * @see Util_Webservice_Interface
 */
require_once 'Util/Webservice/Interface.php';

/**
 * @category Library
 * @package Util
 * @subpackage Webservice
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
abstract class Util_Webservice_Abstract extends Util_Model_Abstract implements Util_Webservice_Interface
{
	/**
	 * URL do WSDL do webservice.
	 * @var string
	 */
	protected $_wsdl = null;
	
	/**
	 * Configura a URL do WSDL do webservice.
	 *
	 * @param string $wsdl URL do WSDL.
	 * @return void
	 */
	public function __construct($wsdl)
	{
		parent::__construct();
		$this->setWsdl($wsdl);
	}
	
	/**
	 * Altera a URL do WSDL do webservice.
	 *
	 * @param string $wsdl URL do WSDL.
	 * @return Util_Webservice_Interface
	 */
	public function setWsdl($wsdl = null)
	{
		$this->_wsdl = (string)$wsdl;
		return $this;
	}
	
	/**
	 * Recupera a URL do WSDL do webservice.
	 * @return string
	 */
	public function getWsdl()
	{
		return (string)$this->_wsdl;
	}
}
