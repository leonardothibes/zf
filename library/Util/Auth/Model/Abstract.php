<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Auth
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Abstract.php 04/01/2012 15:29:01 leonardo $
 */

/**
 * @see Util_Auth_Model_Interface
 */
require_once 'Util/Auth/Model/Interface.php';

/**
 * @category Library
 * @package Util
 * @subpackage Auth
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
abstract class Util_Auth_Model_Abstract implements Util_Auth_Model_Interface
{
	/**
	 * Adaptador de login.
	 * @var Zend_Auth_Adapter_Interface
	 */
	protected $_adapter = null;
	
	/**
	 * Configura o adaptador de login.
	 */
	public function __construct()
	{
		die(sprintf(
			'Sobrescreva o construtor da classe "%s" configurando o adaptador de login no atributo "_adapter".',
			__CLASS__
		));
	}
	
	/**
	 * Autentica login e senha.
	 *
	 * @param string $login
	 * @param string $senha
	 *
	 * @return Zend_Auth_Result
	 */
	public function authenticate($login, $senha)
	{
		return $this->_adapter->setIdentity($login)
		                      ->setCredential($senha)
		                      ->authenticate();
	}
	
	/**
	 * Inicia a sessão e retorna os dados do usuário.
	 * @return stdClass
	 */
	public function sessionStart()
	{
		$data = $this->_adapter->getResultRowObject();
		$auth = Zend_Auth::getInstance();
		$auth->getStorage()->write($data);
		return $data;
	}
	
	/**
	 * Faz logout removendo os dados do usuário logado da sessão.
	 *
	 * @param bool $destroy Se ativado então destroi toda a sessão.
	 * @return void
	 */
	public function logout($destroy = false)
	{
		$auth = Zend_Auth::getInstance();
		$auth->getStorage()->clear();
		if($destroy) { Zend_Session::destroy(); }
	}
}
