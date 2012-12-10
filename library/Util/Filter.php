<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Filter
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Filter.php 05/11/2010 09:57:18 leonardo $
 */

/**
 * Classe de atalho para os filter do Zend_Framework.
 *
 * @category Library
 * @package Util
 * @subpackage Filter
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Filter
{
	/**
	 * Invoca o filtro solicitado.
	 *
	 * @param string $filter Nome do filtro.
	 * @param array  $params Parâmetros para o filtro.
	 *
	 * @return mixed
	 */
	static public function __callStatic($filter, $params = array())
	{
		$filter      = 'Zend_Filter_' . Util_Format_String::ZendName($filter);
		$zend_filter = new $filter();
		return $zend_filter->filter($params[0]);
	}
}
