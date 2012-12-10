<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Cpf.php 20/10/2010 14:32:09 leonardo $
 */

/**
 * @see Util_Format_Abstract
 */
require_once 'Util/Format/Abstract.php';

/**
 * Rotinas para tratamento de CPF.
 *
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Format_Cpf extends Util_Format_Abstract
{
	/**
	 * Expressão regular para teste de CPF.
	 * @var string
	 */
	const Regex = '/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/';
	
	/**
	 * Testa se um CPF é válido.
	 *
	 * @param mixed $data CPF a ser verificado.
	 * @return bool
	 */
	static public function isValid($data = null)
	{
		//Retirando a máscara.
		$data = self::UnMask($data);
		
		//Se houverem letras no CPF então já retorna false direto.
		if(!is_numeric($data)) { return false; }
		
		//Verificando combinações inválidas de CPF.
		$nulos = array(
			'12345678909','11111111111','22222222222','33333333333',
			'44444444444','55555555555','66666666666','77777777777',
			'88888888888','99999999999','00000000000'
		);
		if(in_array($data, $nulos)) { return false; }
		//Verificando combinações inválidas de CPF.
		
		//Calculando o primeiro dígito verificador.
		$acum = 0;
		for($i = 0; $i < 9; $i++) {
			$acum += $data[$i] * (10-$i);
		}
		
		$x = $acum % 11;
		$acum = ($x > 1) ? (11 - $x) : 0;
		
		if($acum != $data[9]) { return false; }
		//Calculando o primeiro dígito verificador.
		
		//Calcula o segundo dígito verificador.
		$acum = 0;
		for($i = 0; $i < 10; $i++) {
			$acum += $data[$i] * (11 - $i);
		}
		
		$x = $acum % 11;
		$acum = ($x > 1) ? (11 - $x) : 0;
		
		if($acum != $data[10]) { return false; }
		//Calcula o segundo dígito verificador.
		
		//Retorna verdadeiro se o cpf é válido.
		return true;
	}
	
	/**
	 * Inclui uma máscara.
	 *
	 * @param mixed $data CPF a ser mascarado.
	 * @return string
	 */
	static public function Mask($data)
	{
		$data = trim($data);
		$data = substr($data, 0, 3) . '.' . substr($data, 3, 10);
		$data = substr($data, 0, 7) . '.' . substr($data, 7, 12);
		$data = substr($data, 0, 11) . '-' . substr($data, 11, 12);
		return $data;
	}
	
	/**
	 * Retira a máscara.
	 *
	 * @param string CPF a ter sua máscara retirada.
	 * @return string
	 */
	static public function UnMask($data)
	{
		return str_replace(array('.', '-'), '', trim($data));
	}
}
