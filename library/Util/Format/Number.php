<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Number.php 23/11/2010 15:52:24 leonardo $
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
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Format_Number extends Util_Format_Abstract
{
	/**
	 * Formatos de moeda possíveis.
	 */
	const DOLAR = 'U$';
	const EURO  = '€$';
	const REAL  = 'R$';
	
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
	 * Inclui um separador em um número grande para ficar melhor visível.
	 *
	 * IMPORTANTE: O retorno deste método é apenas ilustativo e NÃO
	 *             DEVE ser usado para cálculos.
	 *
	 * @param int $data Número a ser formatado.
	 * @return string
	 */
	static public function toScreen($data)
	{
		return (string)number_format((int)$data, 0, '.', '.');
	}
	
	/**
	 * Formata um número vindo da tela para ir ao banco de dados.
	 *
	 * @param mixed  $number Número a ser formatado.
	 * @param string $format Formato("R$" ou "U$") em que o número ESTÁ.
	 *
	 * @return false|float
	 */
	static public function toDb($number, $format = self::REAL)
	{
		switch($format) {
			case self::REAL:
			case self::EURO:
				$number = str_replace('.', '' , $number);
				$number = str_replace(',', '.', $number);
				return (float)number_format($number, 2, '.', '');
			break;
			case self::DOLAR:
				$number = str_replace(',', '' , $number);
				return (float)number_format($number, 2, '.', '');
			break;
			default:
				return false;
			break;
		}
	}
	
	/**
	 * Formata um número como valor monetário para aparecer na tela.
	 *
	 * IMPORTANTE: O retorno deste método é apenas ilustativo e não
	 *             deve ser usado para cálculos.
	 *
	 * @param float|int $data   Número a ser formatado.
	 * @param string    $format Formato("R$" ou "U$").
	 *
	 * @return false|string
	 */
	static public function toMoney($number, $format = self::REAL)
	{
		if(!is_numeric($number)) {
			return false;
		}
		
		switch($format) {
			case self::REAL:
			case self::EURO:
				return (string)number_format($number, 2, ',', '.');
			break;
			case self::DOLAR:
				return (string)number_format($number, 2, '.', ',');
			break;
			default:
				return false;
			break;
		}
	}
}
