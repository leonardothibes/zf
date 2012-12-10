<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Webservice
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Abstract.php 21/11/2011 11:38:33 leonardo $
 */

/** @see Zend_Soap_Server **/
require_once 'Zend/Soap/Server.php';

/** @see Zend_Soap_AutoDiscover **/
require_once 'Zend/Soap/AutoDiscover.php';

/** @see Util_Webservice_Server_Interface **/
require_once 'Util/Webservice/Server/Interface.php';

/** @see Util_Webservice_Server_Exception **/
require_once 'Util/Webservice/Server/Exception.php';

/** @see Util_Model_Filter **/
require_once 'Util/Model/Filter.php';

/** @see Util_Db_Proc **/
require_once 'Util/Db/Proc.php';

/** @see Util_Db_Table **/
//require_once 'Util/Db/Table.php';

/**
 * @category Library
 * @package Util
 * @subpackage Webservice
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
abstract class Util_Webservice_Server_Abstract implements Util_Webservice_Server_Interface
{
	/**
	 * URL do WSDL do webservice.
	 * @var string
	 */
	protected $_wsdl = null;
	
	/**
	 * Front-end de procedures.
	 * @var Util_Db_Proc
	 */
	protected $procedure = null;
	
	/**
	 * Front-end para os filtros do ZF.
	 * @var Util_Model_Filter
	 */
	protected $filter = null;
	
	/**
	 * Código de sucesso de retorno.
	 * @var int
	 */
	const RETURN_CODE_SUCCESS = 0;
	
	/**
	 * Código de erro de retorno.
	 * @var int
	 */
	const RETURN_CODE_ERROR = -1;
	
	/**
	 * Configura a URL do WSDL do webservice.
	 *
	 * @param string $wsdl URL do WSDL.
	 * @return void
	 */
	final public function __construct($wsdl)
	{
		//URL do WSDL.
		$this->_wsdl = (string)$wsdl;
		
		//Front-end de procedures.
		$this->procedure = new Util_Db_Proc();
		
		//Front-end para os flitros do ZF.
		$this->filter = new Util_Model_Filter();
		
		//Chamando o init caso implementado.
		$this->init();
		
		//Iniciando o servidor.
		$this->_handle();
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
	 * Inicia um servidor Soap.
	 *
	 * @return Util_Webservice_Interface
	 * @throws Util_Webservice_Server_Exception
	 */
	private function _handle()
	{
		if(isset($_GET['wsdl'])) {
			$this->_autoDiscover();
		} else {
			$this->_server();
		}
		return $this;
	}
	
	/**
	 * Gera automaticamente o WSDL a partir de uma classe.
	 *
	 * A classe automaticamente se transforma num webservice,
	 * e todos os seus métodos públicos viram métodos deste
	 * webservice.
	 *
	 * @return Util_Webservice_Interface
	 * @throws Util_Webservice_Server_Exception
	 */
	private function _autoDiscover()
	{
		try {
			$server = new Zend_Soap_AutoDiscover();
			$server->setClass(get_class($this));
			$server->handle();
			return $this;
		} catch(Exception $e) {
			$this->_throw($e);
		}
	}
	
	/**
	 * Executa um servidor Soap.
	 *
	 * @return Util_Webservice_Interface
	 * @throws Util_Webservice_Server_Exception
	 */
	private function _server()
	{
		try {
			$wsdl   = preg_replace('/\?wsdl/', '', $this->_wsdl) . '?wsdl';
			$server = new Zend_Soap_Server($wsdl);
			$server->setObject($this);
			$server->handle();
			return $this;
		} catch(Exception $e) {
			$this->_throw($e);
		}
	}
	
	/**
	 * Testa se um retorno á válido.
	 *
	 * @param mixed $rs Retorno a ser testado.
	 * @return bool
	 * @throws Util_Webservice_Server_Exception Caso o retorno não seja válido.
	 */
	protected function isValid($rs)
	{
		try {
			$default = 'Tipo de retorno inválido';
			if(Util_Format_Array::isValid($rs)) {
				$rs = isset($rs[0]) ? $rs[0] : $rs;
				if(isset($rs['codigo']) and $rs['codigo'] == self::RETURN_CODE_SUCCESS) {
					if((isset($rs['descricao']) and strlen($rs['descricao']))) {
						return true;
					}
				}
				$messagem = (isset($rs['descricao']) and strlen($rs['descricao'])) ? $rs['descricao'] : $default;
				throw new Util_Webservice_Server_Exception($messagem, $rs['codigo']);
			}
			throw new Util_Webservice_Server_Exception($default, self::RETURN_CODE_ERROR);
		} catch(Exception $e) {
			$this->_throw($e);
		}
	}
	
	/**
	 * Autentica um cliente no webservice.
	 *
	 * @param string $hash Hash de autenticação.
	 * @param string $ip   IP do cliente(opcional).
	 *
	 * @return Util_Webservice_Interface
	 * @throws Util_Webservice_Server_Exception
	 */
	protected function authenticate($hash, $ip = null)
	{
		return $this;
	}
	
	/**
	 * Lança uma exception.
	 *
	 * @param Exception $e     Objeto da excessão a ser tratada.
	 * @param bool      $array Se TRUE então retorna o erro em array ao invés de XML.
	 *
	 * @return array|string Código do erro e mensagem.
	 */
	protected function _throw(Exception $e, $array = false)
	{
		$error = array(
			'codigo'    => $e->getCode(),
			'descricao' => Util_Format_String::Decode($e->getMessage())
		);
		
		Util_Debug::Log(sprintf('[%s] %s', $error['codigo'], $error['descricao']));
		return $array ? $error : Util_Format_Array::toXml($error);
	}
}
