<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Interface.php 20/10/2010 13:31:07 leonardo $
 */

/**
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
interface Util_Format_Interface
{
	/**
	 * Testa se é um dado válido.
	 *
	 * @param mixed $data Dado a ser verificado.
	 * @return bool
	 */
	static public function isValid($data);
	
	/**
	 * Limpa todo conteúdo inesperado para o tipo de dado especificado.
	 *
	 * @param mixed $data Dado a ser limpo.
	 * @return string
	 */
	static public function Sanitize($data);
	
	/**
	 * Inclui uma máscara.
	 *
	 * @param mixed $data Dado a ser mascarado.
	 * @return string
	 */
	static public function Mask($data);
	
	/**
	 * Retira a máscara.
	 *
	 * @param string Dado a ter sua máscara retirada.
	 * @return mixed
	 */
	static public function UnMask($data);
}
