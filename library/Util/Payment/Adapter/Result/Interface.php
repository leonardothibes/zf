<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Interface.php 26/06/2012 15:44:50 leonardo $
 */

/**
 * Interface para os retornos que um gateway de pagamento pode emitir.
 *
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
interface Util_Payment_Adapter_Result_Interface
{
	/**
	 * Configura o código de status no gateway.
	 *
	 * @param int $status
	 * @return Util_Payment_Adapter_Result_Interface
	 */
	public function setStatus($status);
	
	/**
	 * Recupera o código de status no gateway.
	 * @return int
	 */
	public function getStatus();
	
	/**
	 * Configura a mensagem de resposta da transação no gateway.
	 *
	 * @param string $message
	 * @return Util_Payment_Adapter_Result_Interface
	 */
	public function setMessage($message);
	
	/**
	 * Recupera a mensagem de resposta da transação no gateway.
	 * @return string
	 */
	public function getMessage();
	
	/**
	 * Configura o código que identifica o pedido no comerciante.
	 *
	 * @param int $merchantOrderId
	 * @return Util_Payment_Adapter_Result_Interface
	 */
	public function setMerchantOrderId($merchantOrderId);
	
	/**
	 * Recupera o código que identifica o pedido no comerciante.
	 * @return int
	 */
	public function getMerchantOrderId();
	
	/**
	 * Configura o código que identifica o pedido no gateway.
	 *
	 * @param string $gatewayOrderId
	 * @return Util_Payment_Adapter_Result_Interface
	 */
	public function setGatewayOrderId($gatewayOrderId);
	
	/**
	 * Recupera o código que identifica o pedido no gateway.
	 * @return string
	 */
	public function getGatewayOrderId();
	
	/**
	 * Configura o código que identifica o pedido na operadora.
	 *
	 * @param string $processorOrderId
	 * @return Util_Payment_Adapter_Result_Interface
	 */
	public function setProcessorOrderId($processorOrderId);
	
	/**
	 * Recupera o código que identifica o pedido na operadora.
	 * @return string
	 */
	public function getProcessorOrderId();
	
	/**
	 * Configura o código que identifica a transação no gateway.
	 *
	 * @param string $gatewayTransactionId
	 * @return Util_Payment_Adapter_Result_Interface
	 */
	public function setGatewayTransactionId($gatewayTransactionId);
	
	/**
	 * Recupera o código que identifica a transação no gateway.
	 * @return string
	 */
	public function getGatewayTransactionId();
	
	/**
	 * Configura o código de tranzação na operadora de crédito.
	 *
	 * @param string $processorTransactionId
	 * @return Util_Payment_Adapter_Result_Interface
	 */
	public function setProcessorTransactionId($processorTransactionId);
	
	/**
	 * Recupera o código de tranzação na operadora de crédito.
	 * @return string
	 */
	public function getProcessorTransactionId();
	
}
