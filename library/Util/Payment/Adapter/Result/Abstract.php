<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Abstract.php 26/06/2012 15:45:51 leonardo $
 */

/**
 * @see Util_Payment_Adapter_Result_Interface
 */
require_once 'Util/Payment/Adapter/Result/Interface.php';

/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
abstract class Util_Payment_Adapter_Result_Abstrac implements Util_Payment_Adapter_Result_Interface
{
	/**
	 * Código de status no gateway.
	 * @var int
	 */
	private $_status = null;
	
	/**
	 * Mensagem de resposta da transação no gateway.
	 * @var string
	 */
	private $_message = null;
	
	/**
	 * Código que identifica o pedido no comerciante.
	 * @var int
	 */
	private $_merchantOrderId = null;
	
	/**
	 * Código que identifica o pedido no gateway.
	 * @var string
	 */
	private $_gatewayOrderId = null;
	
	/**
	 * Código que identifica o pedido na operadora.
	 * @var string
	 */
	private $_processorOrderId = null;
	
	/**
	 * Código que identifica a transação no gateway.
	 * @var string
	 */
	private $_gatewayTransactionId = null;
	
	/**
	 * Código de tranzação na operadora de crédito.
	 * @var string
	 */
	private $_processorTransactionId = null;
	
	/**
	 * Configura o código de status no gateway.
	 *
	 * @param int $status
	 * @return Util_Payment_Adapter_Result_Interface
	 */
	public function setStatus($status)
	{
		$this->_status = (int)$status;
		return $this;
	}
	
	/**
	 * Configura a mensagem de resposta da transação no gateway.
	 *
	 * @param string $message
	 * @return Util_Payment_Adapter_Result_Interface
	 */
	public function setMessage($message)
	{
		$this->_message = (string)$message;
		return $this;
	}
	
	/**
	 * Configura o código que identifica o pedido no comerciante.
	 *
	 * @param int $merchantOrderId
	 * @return Util_Payment_Adapter_Result_Interface
	 */
	public function setMerchantOrderId($merchantOrderId)
	{
		$this->_merchantOrderId = (int)$merchantOrderId;
		return $this;
	}
	
	/**
	 * Configura o código que identifica o pedido no gateway.
	 *
	 * @param string $gatewayOrderId
	 * @return Util_Payment_Adapter_Result_Interface
	 */
	public function setGatewayOrderId($gatewayOrderId)
	{
		$this->_gatewayOrderId = (string)$gatewayOrderId;
		return $this;
	}
	
	/**
	 * Configura o código que identifica o pedido na operadora.
	 *
	 * @param string $processorOrderId
	 * @return Util_Payment_Adapter_Result_Interface
	 */
	public function setProcessorOrderId($processorOrderId)
	{
		$this->_processorOrderId = (string)$processorOrderId;
		return $this;
	}
	
	/**
	 * Configura o código que identifica a transação no gateway.
	 *
	 * @param string $gatewayTransactionId
	 * @return Util_Payment_Adapter_Result_Interface
	 */
	public function setGatewayTransactionId($gatewayTransactionId)
	{
		$this->_gatewayTransactionId = (string)$gatewayTransactionId;
		return $this;
	}
	
	/**
	 * Configura o código de tranzação na operadora de crédito.
	 *
	 * @param string $processorTransactionId
	 * @return Util_Payment_Adapter_Result_Interface
	 */
	public function setProcessorTransactionId($processorTransactionId)
	{
		$this->_processorTransactionId = (string)$processorTransactionId;
		return $this;
	}
}
