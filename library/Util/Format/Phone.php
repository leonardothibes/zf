<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Phone.php 20/10/2010 13:29:11 leonardo $
 */

/**
 * @see Util_Format_Abstract
 */
require_once 'Util/Format/Abstract.php';

/**
 * Rotinas para tratamento de telefone.
 *
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Format_Phone extends Util_Format_Abstract
{
	/**
	 * Expressão regular para teste de telefone.
	 * @var string
	 */
	const Regex = '/^\([0-9]{2}\)\s?[0-9]{4}\-[0-9]{4}$/';
	
	/**
	 * Testa se é um telefone válido.
	 *
	 * @param mixed $data Telefone a ser verificado(com ddd).
	 * @return bool
	 */
	static public function isValid($data = null)
	{
		return (bool)preg_match(self::Regex, $data);
	}
	
	/**
	 * Inclui uma máscara.
	 *
	 * @param mixed $data Telefone a ser mascarado.
	 * @return string
	 */
	static public function Mask($data)
	{
		$ddd  = '(' . substr($data, 0, 2) . ') ';
		$fone = substr($data, 2, 4) . '-' . substr($data, 6, 9);
		return $ddd . $fone;
	}
	
	/**
	 * Retira a máscara de um telefone e retorna tudo numa só string.
	 *
	 * @param string Telefone a ter sua máscara retirada.
	 * @return string
	 */
	static public function UnMask($data)
	{
		if(!self::isValid($data)) {
			return null;
		}
		
		$data = self::UnMaskArray($data);
		return $data['ddd'] . $data['phone'];
	}
	
	/**
	 * Retira a máscara e retorna como array.
	 *
	 * @param string Telefone a ter sua máscara retirada.
	 * @return array|null
	 */
	static public function UnMaskArray($data)
	{
		if(!self::isValid($data)) {
			return null;
		}
		
		$delim = strpos($data, ' ') > 0 ? ' ' : ')';
		list($ddd, $fone) = explode($delim, $data);
		return array(
			'ddd'   => str_replace(array('(', ')'), '', $ddd),
			'phone' => str_replace('-', '', $fone)
		);
	}
}
