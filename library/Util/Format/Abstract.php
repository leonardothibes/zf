<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Abstract.php 20/10/2010 13:33:59 leonardo $
 */

/**
 * @see Util_Format_Interface
 */
require_once 'Util/Format/Interface.php';

/**
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
abstract class Util_Format_Abstract implements Util_Format_Interface
{
	/**
	 * Expressão regular para teste do tipo de dado.
	 * @var string
	 */
	const Regex = null;
	
	/**
	 * Limpa todo conteúdo inesperado para o tipo de dado especificado.
	 *
	 * @param mixed $data Dado a ser limpo.
	 * @return string
	 */
	static public function Sanitize($data)
	{
		return $data;
	}
	
	/**
	 * Inclui uma máscara.
	 *
	 * @param mixed $data Dado a ser mascarado.
	 * @return string
	 */
	static public function Mask($data)
	{
		return $data;
	}
	
	/**
	 * Retira a máscara.
	 *
	 * @param string Dado a ter sua máscara retirada.
	 * @return mixed
	 */
	static public function UnMask($data)
	{
		return $data;
	}
}
