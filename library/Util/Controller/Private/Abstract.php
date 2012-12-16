<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Application
 * @package Default
 * @subpackage Controllers
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: ControllerPrivateAbstract.php 01/06/2012 17:42:56 leonardo $
 */

/**
 * @see ControllerAbstract
 */
require_once 'Util/Controller/Private/Abstract.php';

/**
 * Controller base para as páginas privadas.
 *
 * @category Application
 * @package Default
 * @subpackage Controllers
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
abstract class Util_Controller_Private_Abstract extends Util_Controller_Abstract
{
	/**
	 * Configurações primárias do site logado.
	 * @see application/default/controllers/SiteController#preDispatch()
	 */
	public function preDispatch()
	{
		//Executando configurações do Site.
		parent::preDispatch();
	}
}
