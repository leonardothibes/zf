<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Auth
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Interface.php 04/01/2012 15:30:00 leonardo $
 */

/**
 * @category Library
 * @package Util
 * @subpackage Auth
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
interface Util_Auth_Model_Interface
{
	/**
	 * Configura o adaptador de login.
	 */
	public function __construct();
	
	/**
	 * Autentica login e senha.
	 *
	 * @param string $login
	 * @param string $senha
	 *
	 * @return Zend_Auth_Result
	 */
	public function authenticate($login, $senha);
	
	/**
	 * Inicia a sessão e retorna os dados do usuário
	 * @return stdClass
	 */
	public function sessionStart();
	
	/**
	 * Faz logout removendo os dados do usuário logado da sessão.
	 *
	 * @param bool $destroy Se ativado então destroi toda a sessão.
	 * @return void
	 */
	public function logout($destroy = false);
}
