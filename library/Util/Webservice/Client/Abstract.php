<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Webservice
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Abstract.php 21/11/2011 11:22:06 leonardo $
 */

/**
 * @see Zend_Soap_Client
 */
require_once 'Zend/Soap/Client.php';

/**
 * @see Util_Webservice_Abstract
 */
require_once 'Util/Webservice/Abstract.php';

/**
 * @see Util_Webservice_Client_Interface
 */
require_once 'Util/Webservice/Client/Interface.php';

/**
 * @category Library
 * @package Util
 * @subpackage Webservice
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
abstract class Util_Webservice_Client_Abstract extends Util_Webservice_Abstract implements Util_Webservice_Client_Interface
{
	/**
	 * Objeto de conexão com o webservice.
	 * @var SoapClient|Zend_Soap_Client
	 */
	private $_ws = null;
	
	/**
	 * Se ativada então usa a classe de conexão nativa do PHP.
	 * @var bool
	 */
	private $_useNativeClient = false;
	
	/**
	 * Hash de autenticação.
	 * @var string
	 */
	protected $_hash = null;
	
	/**
	 * Flag de ativação da auto conversão de XML.
	 * @var bool
	 */
	protected $_autoXmlDecodeEnabled = false;
	
	/**
	 * ID do cache.
	 * @var string
	 */
	protected $_id = null;
	
	/**
	 * Tempo de vida do cache.
	 * @var int
	 */
	protected $_ttl = 0;
	
	/**
	 * Configura a URL do WSDL do webservice.
	 *
	 * @param string $wsdl URL do WSDL.
	 * @return void
	 */
	final public function __construct($wsdl = null)
	{
		parent::__construct($wsdl);
		$this->init();
	}
	
	/**
	 * Método para atuar como construtor nas classes filhas.
	 * @return Util_Webservice_Interface
	 */
	protected function init()
	{
		//Não faz nada.
	}
	
	/**
	 * Ativa/desativa o uso da classe cliente nativa do PHP.
	 *
	 * @param bool $flag
	 * @return Util_Webservice_Client_Interface
	 */
	public function setNativeClient($flag = true)
	{
		$this->_useNativeClient = (bool)$flag;
		return $this;
	}
	
	/**
	 * Verifica se o uso da classe de cliente nativa está habilitada.
	 * @return bool
	 */
	public function getNativeClient()
	{
		return (bool)$this->_useNativeClient;
	}
	
	/**
	 * Configura o hash de autenticação da chamada do webservice.
	 *
	 * Em branco zera o valor.
	 *
	 * @param string $hash
	 * @return Util_Webservice_Client_Interface
	 */
	public function setHash($hash = null)
	{
		$this->_hash = (string)$hash;
		return $this;
	}
	
	/**
	 * Recupera o hash de autenticação em uso no momento.
	 * @return string
	 */
	public function getHash()
	{
		return (string)$this->_hash;
	}
	
	/**
	 * Ativa/desativa a auto conversão de XML.
	 *
	 * @param bool $flag
	 * @return Util_Webservice_Client_Interface
	 */
	public function setAutoXmlDecode($flag = true)
	{
		$this->_autoXmlDecodeEnabled = (bool)$flag;
		return $this;
	}
	
	/**
	 * Verifica se a auto conversão de XML está ativa.
	 * @return bool
	 */
	public function getAutoXmlDecode()
	{
		return (bool)$this->_autoXmlDecodeEnabled;
	}
	
	/**
	 * Decodifica um retorno em XML.
	 *
	 * @param string $xml
	 * @return array
	 */
	protected function xmlDecode($xml)
	{
		return ($this->_autoXmlDecodeEnabled and Util_Format_Xml::isValid($xml)) ? Util_Format_Xml::toArray($xml) : $xml;
	}
	
	/**
	 * Configura o tempo de vida do cache.
	 *
	 * Se a aplicação estiver rodando em ambiente
	 * de testes então não ativa o cache.
	 *
	 * @param string $id  ID da variável de cache.
	 * @param int    $min Tempo de vida do cache em minutos(em branco zera o cache).
	 *
	 * @return Util_Webservice_Client_Interface
	 */
	public function setCache($id, $min = 0)
	{
		if(APPLICATION_ENV != 'testing') {
			$this->_id  = (string)$id;
			$this->_ttl = (int)$min;
		}
		return $this;
	}
	
	/**
	 * Chama um método em um webservice.
	 *
	 * @param string $method Nome do método.
	 * @param array  $params Parâmetros do método.
	 *
	 * @return mixed Retorno do método.
	 */
	public function __call($method, $params = array())
	{
		try {
			//Conectando ao webservice.
			$this->_connect();
			
			//Adicionando o hash e autenticação quando houver.
			if(strlen($this->_hash)) {
				array_unshift($params, $this->_hash);
			}
			
			if($this->_cacheEnabled and strlen($this->_id)) {
				//Chamada com uso de cache.
				if(!$this->test($this->_id)) {
					$result = $this->_ws->__call($method, $params);
					$this->save($this->xmlDecode($result), $this->_id, $this->_ttl);
				}
				return $this->load($this->_id);
			} else {
				//Chamada sem cache.
				$result = $this->_ws->__call($method, $params);
				return $this->xmlDecode($result);
			}
		} catch(Exception $e) {
			$this->_throw($e->getMessage(), $e->getCode());
		}
	}
	
	/**
	 * Conecta ao webservice.
	 */
	protected function _connect()
	{
		try {
			if(!extension_loaded('soap')) {
				$this->_throw('A extensão soap do PHP não foi carregada.', Util_Webservice_Client_Exception::NO_EXTENSION_LOADED);
			}
			
			if(!strlen($this->_wsdl)) {
				$this->_throw('O WSDL não pode estar e branco.', Util_Webservice_Client_Exception::WSDL_EMPTY);
			}
			$class = $this->_useNativeClient ? 'SoapClient' : 'Zend_Soap_Client';
			$this->_ws = new $class($this->_wsdl);
		} catch(Exception $e) {
			$this->_throw($e->getMessage(), $e->getCode());
		}
	}
	
	/**
	 * Lança uma exception.
	 *
	 * @param string $message Mensagem de erro.
	 * @param int    $code    Código de erro.
	 */
	private function _throw($message, $code = 0)
	{
		require_once 'Util/Webservice/Client/Exception.php';
		throw new Util_Webservice_Client_Exception($message, $code);
	}
}
