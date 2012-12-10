<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Interface.php 26/06/2012 15:31:22 leonardo $
 */

/**
 * @see Util_Payment_Adapter_Result_Interface
 */
require_once 'Util/Payment/Adapter/Result/Interface.php';

/**
 * Interface para retorno de CAPTURA dos gateways de pagamento.
 *
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
interface Util_Payment_Adapter_Capture_Interface extends Util_Payment_Adapter_Result_Interface
{
	/**
	 * Configura se a captura do valor do pedido pela operadora foi total ou não.
	 *
	 * @param bool $totalAmountWasCaptured
	 * @return Util_Payment_Adapter_Result_Interface
	 */
	public function setTotalAmountWasCaptured($totalAmountWasCaptured);
	
	/**
	 * Informa se a captura do valor do pedido pela operadora foi total ou não.
	 *
	 * @return bool TRUE : Captura total.
	 *              FALSE: Captura parcial.
	 */
	public function getTotalAmountWasCaptured();
	
	/**
	 * Configura o valor capturado.
	 *
	 * @param float $capturedAmount
	 * @return Util_Payment_Adapter_Result_Interface
	 */
	public function setCapturedAmount($capturedAmount);
	
	/**
	 * Recupera o valor capturado.
	 * @return float
	 */
	public function getCapturedAmount();
	
}
