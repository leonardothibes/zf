<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Abstract.php 20/06/2012 16:30:56 leonardo $
 */

/**
 * @see Util_Payment_Adapter_Interface
 */
require_once 'Util/Payment/Adapter/Interface.php';

/**
 * @category Library
 * @package Util
 * @subpackage Payment
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
abstract class Util_Payment_Adapter_Abstract implements Util_Payment_Adapter_Interface
{
	/**
	 * Versão da API do gateway.
	 * @var string
	 */
	protected $_apiVersion = '0.0.0.0';
	
	/**
	 * Parâmetros de configuração para o gateway.
	 * @var array
	 */
	protected $_config = array();
	
	/**
	 * Campos requeridos na configuração.
	 * @var array
	 */
	protected $_required = array();
	
	/**
	 * Configura os parâmetros do gateway de pagamento.
	 *
	 * @param array $config Parâmetros de configuração para o gateway.
	 * @return void
	 */
	public function __construct($config = array())
	{
		$this->_config = (array)$config;
		$this->init();
	}
	
	/**
	 * Método auxiliar para configuração dos adapters.
	 * @return void
	 */
	protected function init()
	{
		//Implementar em cada adapter.
	}
	
	/**
	 * Retorna os parâmetros de configuração do gateway.
	 *
	 * @param bool $object Se ativada esta flag então retorna o resultado como Zend_Config.
	 * @return array|Zend_Config
	 */
	public function getConfig($object = false)
	{
		if($object === true) {
			return new Zend_Config($this->_config);
		}
		return (array)$this->_config;
	}
	
	/**
	 * Retorna o nome do adapter do gateway de pagamento utilizado no momento.
	 * @return string
	 */
	public function getAdapter()
	{
		$class = strtolower(get_class($this));
		return (string)(str_replace('Util_Payment_Adapter_', '', $class));
	}
	
	/**
	 * Retorna a versão da API do gateway(quando aplicável).
	 * @return string
	 */
	public function getApiVersion()
	{
		return (string)$this->_apiVersion;
	}
	
	/**
	 * Lança uma excessão.
	 *
	 * @param string $message Mensagem da excessão.
	 * @param int    $code    Código da excessão.
	 */
	protected function _exception($message, $code = 0)
	{
		require_once 'Util/Payment/Adapter/Exception.php';
		throw new Util_Payment_Adapter_Exception($message, $code);
	}
}
