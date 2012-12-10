<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Auth
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Soap.php 03/11/2010 10:28:27 leonardo $
 */

/**
 * @see Zend_Auth_Adapter_Interface
 */
require_once 'Zend/Auth/Adapter/Interface.php';

/**
 * @see Zend_Auth_Result
 */
require_once 'Zend/Auth/Result.php';

/**
 * @see Zend_Soap_Client
 */
require_once 'Zend/Soap/Client.php';

/**
 * Adaptador de login em webservice compatível com Zend_Auth.
 *
 * @category Library
 * @package Util
 * @subpackage Auth
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Auth_Adapter_Soap implements Zend_Auth_Adapter_Interface
{
	/**
	 * Código de sucesso no autenticação.
	 * @var int
	 */
	const SUCCESS = 0;
	
	/**
	 * Código de erro na autenticação.
	 * @var int
	 */
	const FAILURE = 1;
	
	/**
	 * Código de dados inválidos no cadastro.
	 * @var int
	 */
	const INVALID_USER_DATA = 2;
	 
	/**
	 * Código de usuário inativo.
	 * @var int
	 */
	const USER_DISABLED = 3;
	 
	/**
	 * Objeto de conexão ao webservice.
	 * @var Zend_Soap_Client
	 */
	protected $_soap = null;
	
	/**
	 * URL do WSDL do webservice.
	 * @var string
	 */
	protected $_wsdl = null;
	
	/**
	 * Método do webservice.
	 * @var string
	 */
	protected $_methodToCall = null;
	
	/**
	 * Coluna de status no retorno do wevservice.
	 * @var string
	 */
	protected $_statusColumn = null;
	
	/**
	 * Coluna de mensagem no retorno do webservice.
	 * @var string
	 */
	protected $_messageColumn = null;
	
	/**
	 * Função para o tratamento da senha.
	 * @var string
	 */
	protected $_credentialTreatment = null;
	
	/**
	 * Hash de autenticação do webservice.
	 * @var string
	 */
	protected $_hash = null;
	
	/**
	 * Usuário.
	 * @var string
	 */
	protected $_identity = null;
	
	/**
	 * Senha.
	 * @var string
	 */
	protected $_credential = null;
	
	/**
	 * Dados do usuário autenticado.
	 *
	 * Estes dados só ficam disponíveis
	 * após uma autenticação bem sucedida.
	 *
	 * @var array|bool
	 */
	protected $_resultRow = false;
	
	/**
	 * Configura as opções de autenticação.
	 *
	 * Para que a autenticação seja possível o webservice
	 * deve obrigatoriamente retornar array ou XML.
	 *
	 * @param string $wsdl                URL do WSDL do webservice.
	 * @param string $methodToCall        Método do webservice.
	 * @param string $statusColumn        Coluna de status no retorno do wevservice.
	 * @param string $messageColumn       Coluna de mensagem no retorno do wevservice.
	 * @param string $credentialTreatment Método de tratamento da senha(opcional).
	 *
	 * @return void
	 */
	public function __construct($wsdl, $methodToCall, $statusColumn, $messageColumn, $credentialTreatment = null)
	{
		//Configurando a conexão ao webservice.
		$this->setWsdl($wsdl)
		     ->setMethodToCall($methodToCall)
		     ->setStatusColumn($statusColumn)
		     ->setMessageColumn($messageColumn)
		     ->setCredentialTreatment($credentialTreatment);
		
		//Conectando ao webservice.
		$this->_connect();
	}
	
	/**
	 * Configura o Hash de autenticação do webservice.
	 *
	 * @var string $hash
	 * @return Zend_Auth_Adapter_Interface
	 */
	public function setHash($hash = null)
	{
		$this->_hash = (string)$hash;
		return $this;
	}
	
	/**
	 * Recupera o Hash de autenticação do webservice.
	 * @return string
	 */
	public function getHash()
	{
		return $this->_hash;
	}
	
	/**
	 * Configura a URL do WSDL do webservice.
	 *
	 * @param string $wsdl
	 * @return Zend_Auth_Adapter_Interface
	 */
	public function setWsdl($wsdl = null)
	{
		$this->_wsdl = (string)$wsdl;
		return $this;
	}
	
	/**
	 * Recupera a URL do WSDL do webservice.
	 * @return string
	 */
	public function getWsdl()
	{
		return $this->_wsdl;
	}
	
	/**
	 * Configura o método do webservice.
	 *
	 * @param string $methodToCall
	 * @return Zend_Auth_Adapter_Interface
	 */
	public function setMethodToCall($methodToCall = null)
	{
		$this->_methodToCall = (string)$methodToCall;
		return $this;
	}
	
	/**
	 * Recupera o método do webservice.
	 * @return string
	 */
	public function getMethodToCall()
	{
		return $this->_methodToCall;
	}
	
	/**
	 * Configura a coluna de status no retorno do webservice.
	 *
	 * @param string $statusColumn
	 * @return Zend_Auth_Adapter_Interface
	 */
	public function setStatusColumn($statusColumn)
	{
		$this->_statusColumn = (string)$statusColumn;
		return $this;
	}
	
	/**
	 * Recupera a coluna de status no retorno do webservice.
	 * @return string
	 */
	public function getStatusColumn()
	{
		return $this->_statusColumn;
	}
	
	/**
	 * Configura a coluna de mensagem no retorno do webservice.
	 *
	 * @param $statusColumn
	 * @return Zend_Auth_Adapter_Interface
	 */
	public function setMessageColumn($messageColumn)
	{
		$this->_messageColumn = (string)$messageColumn;
		return $this;
	}
	
	/**
	 * Recupera a coluna de mensagem no retorno do webservice.
	 * @return string
	 */
	public function getMessageColumn()
	{
		return $this->_messageColumn;
	}
	
	/**
	 * Configura o método de tratamento da senha.
	 *
	 * @param string $credentialTreatment
	 * @return Zend_Auth_Adapter_Interface
	 * @throws Util_Auth_Adapter_Exception Caso o tipo de tratamento seja inválido.
	 */
	public function setCredentialTreatment($credentialTreatment = null)
	{
		if(strlen($credentialTreatment) and !strpos($credentialTreatment, '?')) {
			$this->_throw('Tipo de tratameno de senha inválido.');
		}
		
		$credentialTreatment        = str_replace('(?)', '', strtolower(trim((string)$credentialTreatment)));
		$this->_credentialTreatment = $credentialTreatment;
		
		return $this;
	}
	
	/**
	 * Recupera o método de tratamento da senha.
	 * @return string
	 */
	public function getCredentialTreatment()
	{
		return $this->_credentialTreatment;
	}
	
	/**
	 * Define o usuário.
	 *
	 * @param string $credential
	 * @return Zend_Auth_Adapter_Interface
	 */
	public function setIdentity($identity = null)
	{
		$this->_identity = (string)$identity;
		return $this;
	}
	
	/**
	 * Recupera o usuário.
	 * @return string
	 */
	public function getIdentity()
	{
		return $this->_identity;
	}
	
	/**
	 * Define a senha.
	 *
	 * Ao definir a senha já é aplicada a mesma o tratamento configurado em {@link setCredentialTreatment()}.
	 *
	 * @param string $credential
	 * @return Zend_Auth_Adapter_Interface
	 */
	public function setCredential($credential = null)
	{
		if(strlen($this->_credentialTreatment)) {
			$function   = new ReflectionFunction($this->_credentialTreatment);
			$credential = $function->invokeArgs(array($credential));
		}
		
		$this->_credential = (string)$credential;
		return $this;
	}
	
	/**
	 * Recupera a senha.
	 *
	 * A senha é recuperada já com o tratamento configurado em {@link setCredentialTreatment()}.
	 *
	 * @return string
	 */
	public function getCredential()
	{
		return $this->_credential;
	}
	
	/**
	 * Conecta ao webservice.
	 *
	 * @return Zend_Auth_Adapter_Interface
	 * @throws Util_Auth_Adapter_Exception Em caso de erro na conexão.
	 */
	protected function _connect()
	{
		try {
			if(!strlen($this->_wsdl)) {
				$this->_throw('A URL do WSDL não foi informada.');
			}
			
			$this->_soap = new Zend_Soap_Client($this->_wsdl);
			return $this;
		} catch(Exception $e) {
			$this->_throw($e->getMessage(), $e->getCode());
		}
	}
	
	/**
	 * Executa a autenticação.
	 *
	 * @return Zend_Auth_Result
	 * @throws Util_Auth_Adapter_Exception Caso não seja possível autenticar por qualquer motivo.
	 */
	public function authenticate()
	{
		try {
			if(strlen($this->_hash)) {
				$rs = $this->_soap->{$this->_methodToCall}($this->_hash, $this->_identity, $this->_credential);
			} else {
				$rs = $this->_soap->{$this->_methodToCall}($this->_identity, $this->_credential);
			}
			
			if(Util_Format_Xml::isValid($rs)) {
				$rs = Util_Format_Xml::toArray($rs);
			}
			
			if(!isset($rs[$this->_statusColumn])) {
				$this->_throw(sprintf(
					'A coluna "%s" é requerida mas não está presente no retorno do webservice.',
					$this->_statusColumn
				));
			}
			
			if(!isset($rs[$this->_messageColumn])) {
				$this->_throw(sprintf(
					'A coluna "%s" é requerida mas não está presente no retorno do webservice.',
					$this->_messageColumn
				));
			}
			
			return $this->_validate($rs);
		} catch(Exception $e) {
			$this->_throw($e->getMessage(), $e->getCode());
		}
	}
	
	/**
	 * Valida usuário e senha.
	 *
	 * @param array $response
	 * @return Zend_Auth_Result
	 */
	private function _validate(array $response)
	{
		switch($response[$this->_statusColumn]) {
			case self::SUCCESS:
				$this->_resultRow = $response;
				$code = Zend_Auth_Result::SUCCESS;
			break;
			case self::FAILURE:
				$code = Zend_Auth_Result::FAILURE;
			break;
			case self::INVALID_USER_DATA:
				$code = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
			break;
			case self::USER_DISABLED:
				$code = Zend_Auth_Result::FAILURE_UNCATEGORIZED;
			break;
			default:
				$code = Zend_Auth_Result::FAILURE;
			break;
		}
		
		return new Zend_Auth_Result($code, $this->_identity, array($response[$this->_messageColumn]));
	}
	
	/**
	 * Recupera os dados do usuário autenticado.
	 *
	 * @param array|string $returnColumns Colunas a serem retornadas("*" retornar todas).
	 * @param array|string $omitColumns   Colunas a serem omitidas de $returnColumns(opcional).
	 *
	 * @return bool|stdClass
	 */
	public function getResultRowObject($returnColumns = '*', $omitColumns = null)
	{
		if(!$this->_resultRow) {
			return false;
		}
		
		$returnObject = new stdClass();
		
		if($returnColumns != '*') {
			$availableColumns = array_keys($this->_resultRow);
			foreach((array)$returnColumns as $returnColumn) {
				if(in_array($returnColumn, $availableColumns)) {
					$returnObject->{$returnColumn} = $this->_resultRow[$returnColumn];
				}
			}
		} else if(!is_null($omitColumns)) {
			$omitColumns = (array)$omitColumns;
			foreach($this->_resultRow as $resultColumn => $resultValue) {
				if(!in_array($resultColumn, $omitColumns)) {
                    $returnObject->{$resultColumn} = $resultValue;
                }
			}
		} else {
			$returnObject = Util_Format_Array::toObject($this->_resultRow);
		}
		
		return $returnObject;
	}
	
	/**
	 * Lança uma exception.
	 *
	 * @param string $message Mensagem de erro.
	 * @param int    $code    Código de erro.
	 */
	protected function _throw($message, $code = 0)
	{
		require_once 'Util/Auth/Adapter/Exception.php';
		throw new Util_Auth_Adapter_Exception($message, $code);
	}
}
