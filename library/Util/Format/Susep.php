<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Format
 * @author André dos Santos Sabino <de_ssabino@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Susep.php 27/04/2012 15:52:24 jesus $
 */

/**
 * @see Util_Format_Abstract
 */
require_once 'Util/Format/Abstract.php';

/**
 * Rotinas para tratamento de número.
 *
 * @category Library
 * @package Util
 * @subpackage Format
 * @author André dos Santos Sabino <de_ssabino@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Format_Susep extends Util_Format_Abstract
{	
	/**
	 * Testa se é um número válido.
	 *
	 * @param mixed $data Número a ser verificado.
	 * @return bool
	 */
	static public function isValid($data = null)
	{
		return is_numeric($data);
	}
	
	/**
	 * Inclui os separadore de acordo com o formato padrão da Susep.
	 *
	 * IMPORTANTE: O retorno deste método é apenas ilustativo e NÃO
	 *             DEVE ser usado para cálculos.
	 *
	 * @param int $data Número a ser formatado.
	 * @return string
	 */
	static public function toScreen($data)
	{
		//15414.000629/2012-15
		$data = strrev($data);
		$arrData = array(
			substr($data,0,2),
			substr($data,2,4),
			substr($data,6,6),
			substr($data,12)
		);
		$data = $arrData[0] . '-' . $arrData[1] . '/' . $arrData[2] . '.' . $arrData[3];
		$data = strrev($data);
		return (string)$data;
	}
	
	/**
	 * Formata um número vindo da tela para ir ao banco de dados.
	 *
	 * @param mixed  $number Número a ser formatado.
	 * @param string $format Formato("R$" ou "U$") em que o número ESTÁ.
	 *
	 * @return false|float
	 */
	static public function toDb($data)
	{
		$data = str_replace(array('/','-','.'),'',$data);
		return $data;
	}
}
