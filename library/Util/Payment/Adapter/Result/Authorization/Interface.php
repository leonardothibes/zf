<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Interface.php 22/06/2012 17:11:42 leonardo $
 */

/**
 * @see Util_Payment_Adapter_Result_Interface
 */
require_once 'Util/Payment/Adapter/Result/Interface.php';

/**
 * Interface para o retorno de AUTORIZAÇÕES dos gateways de pagamento.
 *
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
interface Util_Payment_Adapter_Result_Authorization_Interface extends Util_Payment_Adapter_Result_Interface
{
	/**
	 * Configura o código de autorização da operadora(caso autorizazo, é claro).
	 *
	 * @param string authorisationNumber
	 * @return Util_Payment_Adapter_Result_Interface
	 */
	public function setAuthorisationNumber($authorisationNumber);
	
	/**
	 * Recupera o código de autorização da operadora(caso autorizazo, é claro).
	 * @return string
	 */
	public function getAuthorisationNumber();
	
}
