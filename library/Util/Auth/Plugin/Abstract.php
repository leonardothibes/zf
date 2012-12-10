<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Auth
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Abstract.php 05/01/2012 09:38:14 leonardo $
 */

/** @see Zend_Controller_Plugin_Abstract **/
require_once 'Zend/Controller/Plugin/Abstract.php';

/** @see Zend_Controller_Request_Abstract **/
require_once 'Zend/Controller/Request/Abstract.php';

/** @see Zend_Acl **/
require_once 'Zend/Acl.php';

/** @see Zend_Auth **/
require_once 'Zend/Auth.php';

/** @see Auth_Acl **/
require_once 'Auth/Acl.php';

/** @see Util_Auth_Plugin_Interface **/
require_once 'Util/Auth/Plugin/Interface.php';

/**
 * @category Library
 * @package Util
 * @subpackage Auth
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
abstract class Util_Auth_Plugin_Abstract extends Zend_Controller_Plugin_Abstract implements Util_Auth_Plugin_Interface
{
	/**
	 * Instância da Zend_Acl
	 * @var Zend_Acl
	 */
	protected $_acl = null;
	
	/**
	 * Construtor.
	 *
	 * @param Zend_Acl $acl
	 * @return void
	 */
	public function __construct(Zend_Acl $acl)
	{
		$this->_acl = $acl;
	}
	
    /**
     * Lista as roles registradas.
     * @return array
     */
    public function getRoles()
    {
    	return $this->_acl->getRoles();
    }
    
    /**
     * Lista os resources registrados.
     * @return array
     */
    public function getResources()
    {
    	return $this->_acl->getResources();
    }
}
