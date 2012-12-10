<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Model
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Interface.php 21/11/2011 08:29:01 leonardo $
 */

/**
 * Interface padrão para todas as models.
 *
 * @category Library
 * @package Util
 * @subpackage Model
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
interface Util_Model_Interface
{
	/**
	 * Testa se um retorno á válido.
	 *
	 * @param mixed $data Retorno a ser testado.
	 * @return bool
	 * @throws Model_Exception Caso o retorno não seja válido.
	 */
	public function isValid($data);
	
	/**
	 * Limpa o cache.
	 *
	 * @param string $id ID do cache.
	 * @return bool
	 */
	public function clear($id = null);
}
