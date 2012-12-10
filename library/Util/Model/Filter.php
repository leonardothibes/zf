<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Model
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Filter.php 21/11/2011 08:32:43 leonardo $
 */

/**
 * @see Zend_Loader
 */
require_once 'Zend/Loader.php';

/**
 * Front-end para os filtros de entrada de dados do Zend Framework.
 *
 * @category Library
 * @package Util
 * @subpackage Model
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Model_Filter
{
	/**
	 * Filtra um dado de entrado usando os filtros do ZF.
	 *
	 * @param string $filter Nome do filtro.
	 * @param array  $params Dado a ser filtrado.
	 *
	 * @return mixed
	 */
	public function __call($filter, $params = array())
	{
		try {
			$filter = 'Zend_Filter_' . $filter;
			Zend_Loader::loadClass($filter);
			
			$zend_filter = new $filter();
			return $zend_filter->filter($params[0]);
		} catch(Exception $e) {
			require_once 'Util/Model/Exception.php';
			throw new Util_Model_Exception(
				sprintf('O filtro "%s" não foi encontrado.', $filter),
				Util_Model_Exception::FILTER_NOT_FOUND
			);
		}
	}
}
