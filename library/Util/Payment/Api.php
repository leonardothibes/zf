<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Api.php 20/06/2012 16:34:31 leonardo $
 */

/**
 * API de pagamento.
 *
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Payment_Api
{
	/**
	 * Factory para os gateways de pagamento.
	 *
	 * Para saber quais os gateways de pagamento suportados
	 * chame o método "gateways" desta mesma classe.
	 *
	 * Para saber se determinado gateway de pagamento é suportado
	 * chame o método "isSupported" desta mesma classe.
	 *
	 * @param string            $adapter Gateway de pagamento a ser utilizado.
	 * @param array|Zend_Config $config  Parâmetros de configuração para o gateway.
	 *
	 * @return Util_Payment_Adapter_Interface
	 * @throws Util_Payment_Exception
	 */
	static public function factory($adapter, $config = array())
	{
		//Normalizando configuração.
		if($config instanceof Zend_Config) {
			$config = $config->toArray();
		}
		
		//Normalizando o nome do adapter.
		$adapter = ucfirst(strtolower((string)$adapter));
		$class   = sprintf('Util_Payment_Adapter_%s', $adapter);
		
		try {
			//Verificando compatibilidade.
			if(!self::isSupported($adapter)) {
				self::exception('Gateway não suportado');
			}
			
			//Tentando carregar a classe.
			Zend_Loader::loadClass($adapter);
			$gateway = new $class($config);
			
			//Validando adaptador.
			if(!$gateway instanceof Util_Payment_Adapter_Interface) {
				self::exception('Tipo de adaptador de pagamento inválido.');
			}
			
			return $gateway;
		} catch(Zend_Exception $e) {
			self::exception($e->getMessage());
		}
	}
	
	/**
	 * Verifica se determinado gateway de pagamento é suportado.
	 *
	 * @param string $gateway Nome do gateway.
	 * @return bool
	 */
	static public function isSupported($gateway)
	{
		return (bool)in_array(strtolower((string)$gateway), self::gateways());
	}
	
	/**
	 * Lista os gateways de pagamento suportados.
	 * @return Array
	 */
	static public function gateways()
	{
		return array('braspag', 'maxipago');
	}
	
	/**
	 * Lança uma exception.
	 *
	 * @param string $message Mensagem.
	 * @param int    $code    Código.
	 */
	static private function exception($message, $code = Util_Payment_Exception::INVALID_ADAPTER)
	{
		require_once 'Util/Payment/Exception.php';
		throw new Util_Payment_Exception($message, $code);
	}
}
