<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Auth
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Interface.php 05/01/2012 09:36:16 leonardo $
 */

/**
 * @category Library
 * @package Util
 * @subpackage Auth
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
interface Util_Auth_Plugin_Interface
{
	/**
	 * Construtor.
	 *
	 * @param Zend_Acl $acl
	 * @return void
	 */
	public function __construct(Zend_Acl $acl);

	/**
	 * Testa se o usuário está logado.
	 *
	 * Executa antes do dispatch do {@link Zend_Controller}
	 *
	 * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request);

    /**
     * Obtém o nível de privilégio do usuário logado no momento.
     * @return string
     */
    static public function getRole();
    
    /**
     * Lista as roles registradas
     * @return array
     */
    public function getRoles();
    
    /**
     * Lista os resources registrados.
     * @return array
     */
    public function getResources();
}
