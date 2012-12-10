<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Webservice
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Interface.php 21/11/2011 11:07:50 leonardo $
 */

/**
 * @see Util_Webservice_Interface
 */
require_once 'Util/Webservice/Interface.php';

/**
 * Interface para cliente de webservice.
 *
 * @category Library
 * @package Util
 * @subpackage Webservice
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
interface Util_Webservice_Client_Interface extends Util_Webservice_Interface
{
	/**
	 * Configura o hash de autenticação da chamada do webservice.
	 *
	 * Em branco zera o valor.
	 *
	 * @param string $hash
	 * @return Util_Webservice_Client_Interface
	 */
	public function setHash($hash = null);
	
	/**
	 * Recupera o hash de autenticação em uso no momento.
	 * @return string
	 */
	public function getHash();
	
	/**
	 * Configura o tempo de vida do cache.
	 *
	 * @param string $id  ID da variável de cache.
	 * @param int    $min Tempo de vida do cache em minutos(em branco zera o cache).
	 *
	 * @return Util_Webservice_Client_Interface
	 */
	public function setCache($id, $min = 0);
}
