<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Application
 * @package Default
 * @subpackage Models
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Model.php 05/01/2012 09:16:07 leonardo $
 */

/**
 * @see Util_Auth_Model_Abstract
 */
require_once 'Util/Auth/Model/Abstract.php';

/**
 * Model de autenticação.
 *
 * @category Application
 * @package Default
 * @subpackage Models
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Auth_Model extends Util_Auth_Model_Abstract
{
	/**
	 * Configura a model de login.
	 */
	public function __construct()
	{
		$this->_adapter = new Util_Auth_Adapter_Soap(
			'http://zf.local/wsdl',
			'autenticar',
			'codigo',
			'descricao',
			'MD5(?)'
		);
		$this->_adapter->setHash('hash');
	}
}
