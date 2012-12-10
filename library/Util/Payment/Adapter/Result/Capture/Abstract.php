<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Abstract.php 26/06/2012 15:36:42 leonardo $
 */

/**
 * @see Util_Payment_Adapter_Capture_Interface
 */
require_once 'Util/Payment/Adapter/Capture/Interface.php';

/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
abstract class Util_Payment_Adapter_Capture_Abstract implements Util_Payment_Adapter_Capture_Interface
{
	/**
	 * Status de captura total.
	 * @var bool
	 */
	private $_totalAmountWasCaptured = false;
	
	/**
	 * Valor capturado.
	 * @var float
	 */
	private $_capturedAmount = 0.00;
	
	/**
	 * Configura se a captura do valor do pedido pela operadora foi total ou não.
	 *
	 * @param bool $totalAmountWasCaptured
	 * @return Util_Payment_Adapter_Result_Interface
	 */
	public function setTotalAmountWasCaptured($totalAmountWasCaptured)
	{
		$this->_totalAmountWasCaptured = (bool)$totalAmountWasCaptured;
		return $this;
	}
	
	/**
	 * Informa se a captura do valor do pedido pela operadora foi total ou não.
	 *
	 * @return bool TRUE : Captura total.
	 *              FALSE: Captura parcial.
	 */
	public function getTotalAmountWasCaptured()
	{
		return (bool)$this->_totalAmountWasCaptured;
	}
	
	/**
	 * Configura o valor capturado.
	 *
	 * @param float $capturedAmount
	 * @return Util_Payment_Adapter_Result_Interface
	 */
	public function setCapturedAmount($capturedAmount)
	{
		$this->_capturedAmount = (float)$capturedAmount;
		return $this;
	}
	
	/**
	 * Recupera o valor capturado.
	 * @return float
	 */
	public function getCapturedAmount()
	{
		return (bool)$this->_capturedAmount;
	}
}
