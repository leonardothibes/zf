<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Abstract.php 26/06/2012 11:35:19 leonardo $
 */

/**
 * @see Util_Payment_Adapter_Result_Authorization_Interface
 */
require_once 'Util/Payment/Adapter/Result/Authorization/Interface.php';

/**
 * @see Util_Payment_Adapter_Result_Abstrac
 */
require_once 'Util/Payment/Adapter/Result/Abstrac.php';

/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
abstract class Util_Payment_Adapter_Authorization_Abstract
	extends    Util_Payment_Adapter_Result_Abstrac
	implements Util_Payment_Adapter_Authorization_Interface
{
	/**
	 * Código de autorização da operadora.
	 * @var int
	 */
	private $_authorisationNumber = null;
	
	/**
	 * Configura o código de autorização da operadora(caso autorizazo, é claro).
	 *
	 * @param string authorisationNumber
	 * @return Util_Payment_Adapter_Result_Interface
	 */
	public function setAuthorisationNumber($authorisationNumber)
	{
		$this->_authorisationNumber = (string)$authorisationNumber;
		return $this;
	}
	
	/**
	 * Recupera o código de autorização da operadora(caso autorizazo, é claro).
	 * @return string
	 */
	public function getAuthorisationNumber()
	{
		return (string)$this->_authorisationNumber;
	}
}
