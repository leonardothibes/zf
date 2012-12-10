<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Auth
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: DbProc.php 27/01/2012 13:58:45 leonardo $
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
 * @see Util_Db_Proc
 */
require_once 'Util/Db/Proc.php';

/**
 * Adaptador de login em procedure compatível com Zend_Auth.
 *
 * @category Library
 * @package Util
 * @subpackage Auth
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Auth_Adapter_DbProc implements Zend_Auth_Adapter_Interface
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
	 * Objeto front-end de procedures.
	 * @var Util_Db_Proc
	 */
	protected $_procObject = null;
	
	/**
	 * Procedure a ser chamada.
	 * @var string
	 */
	protected $_procToCall = null;
	
	/**
	 * Coluna de status no retorno da procedure.
	 * @var string
	 */
	protected $_statusColumn = null;
	
	/**
	 * Coluna de mensagem no retorno da procedure.
	 * @var string
	 */
	protected $_messageColumn = null;
	
	/**
	 * Método para o tratamento da senha.
	 * @var string
	 */
	protected $_credentialTreatment = null;
	
	/**
	 * Login do usuário.
	 * @var string
	 */
	protected $_identity = null;
	
	/**
	 * Senha do usuário.
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
	 * @param Zend_Db_Adapter_Abstract $db                  Objeto de conexão com o banco de dados.
	 * @param string                   $procToCall          Procedure a ser chamada.
	 * @param string                   $statusColumn        Coluna de status no retorno da procedure.
	 * @param string                   $messageColumn       Coluna de mensagem no retorno da procedure.
	 * @param string                   $credentialTreatment Método para o tratamento da senha.
	 * @param string                   $inputCharset        Charset de entrada no banco de dados.
	 * @param string                   $outputCharset       Charset de saída do banco de dados.
	 *
	 * @return void
	 */
	public function __construct(Zend_Db_Adapter_Abstract $db, $procToCall, $statusColumn, $messageColumn, $credentialTreatment = null, $inputCharset = 'utf-8', $outputCharset = 'utf-8')
	{
		$this->setDbObject($db)
		     ->setProcToCall($procToCall)
		     ->setStatusColumn($statusColumn)
		     ->setMessageColumn($messageColumn)
		     ->setCredentialTreatment($credentialTreatment)
		     ->setCharsetInput($inputCharset)
		     ->setCharsetOutput($outputCharset);
	}
	
	/**
	 * Configura o objeto de conexão.
	 *
	 * @param Zend_Db_Adapter_Abstract $db
	 * @return Zend_Auth_Adapter_Interface
	 */
	public function setDbObject(Zend_Db_Adapter_Abstract $db)
	{
		$this->_procObject = new Util_Db_Proc($db);
		return $this;
	}
	
	/**
	 * Recupera o objeto de conexão.
	 * @return Zend_Db_Adapter_Abstract
	 */
	public function getDbObject()
	{
		return $this->_procObject;
	}
	
	/**
	 * Configura a procedure a ser chamada.
	 *
	 * @param string $procToCall
	 * @return Zend_Auth_Adapter_Interface
	 */
	public function setProcToCall($procToCall)
	{
		$this->_procToCall = (string)$procToCall;
		return $this;
	}
	
	/**
	 * Recupera o nome da procedure usada no momento.
	 * @return string
	 */
	public function getProcToCall()
	{
		return (string)$this->_procToCall;
	}
	
	/**
	 * Configura a coluna de status no retorno da procedure.
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
	 * Recupera o nome da coluna de status no retorno da procedure.
	 * @return string
	 */
	public function getStatusColumn()
	{
		return (string)$this->_statusColumn;
	}
	
	/**
	 * Configura a coluna de mensagem no retorno da procedure.
	 *
	 * @param string $messageColumn
	 * @return Zend_Auth_Adapter_Interface
	 */
	public function setMessageColumn($messageColumn)
	{
		$this->_messageColumn = (string)$messageColumn;
		return $this;
	}
	
	/**
	 * Recupera o nome da coluna de mensagem no retorno da procedure.
	 * @return string
	 */
	public function getMessageColumn()
	{
		return (string)$this->_messageColumn;
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
		return sprintf('%s(?)', $this->_credentialTreatment);
	}
	
	/**
	 * Configura o charset de input.
	 *
	 * @param string $charset
	 * @return Zend_Auth_Adapter_Interface
	 */
	public function setCharsetInput($charset)
	{
		$this->_procObject->setCharsetInput($charset)
		                  ->setAutoCharsetEncode();
		return $this;
	}
	
	/**
	 * Recupera o charset de input usado no momento.
	 * @return string
	 */
	public function getCharsetInput()
	{
		return $this->_procObject->getCharsetInput();
	}
	
	/**
	 * Configura o charset de output.
	 *
	 * @param string $charset
	 * @return Zend_Auth_Adapter_Interface
	 */
	public function setCharsetOutput($charset)
	{
		$this->_procObject->setCharsetOutput($charset)
		                  ->setAutoCharsetDecode();
		return $this;
	}
	
	/**
	 * Recupera o charset de output usado no momento.
	 * @return string
	 */
	public function getCharsetOutput()
	{
		return $this->_procObject->getCharsetOutput();
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
		return (string)$this->_identity;
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
		return (string)$this->_credential;
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
			$rs = $this->_procObject->{$this->_procToCall}($this->_identity, $this->_credential);
			$rs = isset($rs[0]) ? $rs[0] : array();
			
			if(!isset($rs[$this->_statusColumn])) {
				$this->_throw(sprintf(
					'A coluna "%s" é requerida mas não está presente no retorno da procedure.',
					$this->_statusColumn
				));
			}
			
			if(!isset($rs[$this->_messageColumn])) {
				$this->_throw(sprintf(
					'A coluna "%s" é requerida mas não está presente no retorno da procedure.',
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
