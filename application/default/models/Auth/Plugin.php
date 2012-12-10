<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Application
 * @package Default
 * @subpackage Models
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Plugin.php 05/01/2012 09:42:46 leonardo $
 */

/**
 * @see Util_Auth_Plugin_Abstract
 */
require_once 'Util/Auth/Plugin/Abstract.php';

/**
 * Plugin de autenticação para o {@link Zend_Controller}.
 *
 * @category Application
 * @package Default
 * @subpackage Models
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Auth_Plugin extends Util_Auth_Plugin_Abstract
{
	/**
	 * Testa se o usuário está logado.
	 *
	 * Executa antes do dispatch do {@link Zend_Controller}
	 *
	 * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
	public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
	    try {
	    	$controller = ucfirst($request->getControllerName()) . ucfirst($request->getControllerKey());
	    	$reflection = new Zend_Reflection_Class($controller);
	    	$resource   = $reflection->getParentClass();
	    	
	    	//Salva a última página autenticada que o cliente tentou acessar.
	    	if($this->isChildOf($resource->name, Auth_Acl::PrivatePage)) {
	    		$_SESSION['REFERER'] = $_SERVER['REQUEST_URI'];
	    	}
	    	
	    	//Se o cliente não estiver logado então exibe a home do site.
	    	if(!$this->_acl->isAllowed(self::getRole(), $resource->name, Auth_Acl::Access)) {
	    		$request->setModuleName(Bootstrap::$module)
	    		        ->setControllerName('index')
	    		        ->setActionName('index');
	    	}
	    } catch(Exception $e) {
	    	//Nada a fazer.
	    }
    }
    
	/**
     * Verifica se uma classe é filha de outra em específico.
     *
     * @param string $className   Nome da suposta classe filha.
     * @param string $classParent Nome da suposta classe pai.
     *
     * @return bool
     */
    private function isChildOf($className, $classParent)
    {
		$class = new ReflectionClass($className);
		if(false === $class) {
			return false;
		}
		do {
			$name = $class->getName();
			if($classParent == $name) {
				return true;
			}
			$interfaces = $class->getInterfaceNames();
			if(is_array($interfaces) and in_array($classParent, $interfaces)) {
				return true;
			}
			$class = $class->getParentClass();
		} while(false !== $class);
		return false;
    }

    /**
     * Obtém o papel do usuário logado no momento.
     * @return string
     */
    static public function getRole()
    {
    	return Zend_Auth::getInstance()->hasIdentity() ? Auth_Acl::User : Auth_Acl::Visitor;
    }
}
