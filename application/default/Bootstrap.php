<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Application
 * @package Bootstrap
 * @subpackage Default
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Bootstrap.php 01/06/2012 17:14:46 leonardo $
 */

/**
 * @category Application
 * @package Bootstrap
 * @subpackage Default
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Default_Bootstrap
{
	/**
	 * Configurando autenticação.
	 */
	static public function _initAuth()
	{
		//Configurando o namespace da sessão.
		$namespace = strtoupper(Bootstrap::$module);
		Zend_Registry::set('session_namespace', new Zend_Session_Namespace($namespace));
		
		$auth = Zend_Auth::getInstance();
		$auth->setStorage(new Zend_Auth_Storage_Session($namespace));
        //Configurando o namespace da sessão.
        
		//Registrando plugin de autenticação.
		$controller = Zend_Controller_Front::getInstance();
		$acl        = new Auth_Acl();
		$plugin     = new Auth_Plugin($acl);
		$controller->registerPlugin($plugin);
	}
}
