<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Application
 * @package Default
 * @subpackage Models
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Acl.php 05/01/2012 09:55:28 leonardo $
 */

/**
 * @see Zend_Acl
 */
require_once 'Zend/Acl.php';

/**
 * @category Application
 * @package Default
 * @subpackage Models
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Auth_Acl extends Zend_Acl
{
	/**
	 * Recursos.
	 */
	const PublicPage  = 'Util_Controller_Abstract';
	const PrivatePage = 'Util_Controller_Private_Abstract';
	
	/**
	 * Papéis.
	 */
	const Visitor = 'visitor';
	const User    = 'user';
	
	/**
	 * Privilégios.
	 */
	const Access = 'access';
	
	/**
	 * Contrutor - iniciando as ALCs.
	 */
	public function __construct()
	{
		//Recursos.
		$this->add(new Zend_Acl_Resource(self::PublicPage));
		$this->add(new Zend_Acl_Resource(self::PrivatePage));
		
		//Papéis.
		$this->addRole(new Zend_Acl_Role(self::Visitor));
		$this->addRole(new Zend_Acl_Role(self::User), self::Visitor);
		
		//Privilégios.
		$this->allow(self::Visitor, self::PublicPage , self::Access);
		$this->allow(self::User   , self::PrivatePage, self::Access);
	}
}
