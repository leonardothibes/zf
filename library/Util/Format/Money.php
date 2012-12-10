<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Money.php 12/03/2012 09:13:18 leonardo $
 */

/**
 * @see Util_Format_Abstract
 */
require_once 'Util/Format/Abstract.php';

/**
 * Rotinas para o tratamento de dinheiro.
 *
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Format_Money extends Util_Format_Abstract
{
	/**
	 * Expressão regular para teste do tipo de dado.
	 * @var string
	 */
	const Regex = null;
	
	/**
	 * Formatos de moeda possíveis.
	 */
	const DOLAR = 'U$';
	const EURO  = '€$';
	const REAL  = 'R$';
	
	/**
	 * Configura os parâmetros monetários do ambiente.
	 *
	 * @param string $format Formato desejado para o retorno(R$, U$, ou €$).
	 * @return void
	 */
	static public function Env($format)
	{
		switch((string)$format) {
			case self::REAL:
			case self::EURO:
				$env = 'pt_BR';
			break;
			case self::DOLAR:
				$env = 'en_US';
			break;
			default:
				require_once 'Util/Format/Exception.php';
				throw new Util_Format_Exception(sprintf('Formato monetário(%s) inválido.', $format));
			break;
		}
		setlocale(LC_NUMERIC , $env);
		setlocale(LC_MONETARY, $env);
	}
	
	/**
	 * Testa se é valor monetário válido para cálculos.
	 *
	 * @param mixed $valor Valor monetário a ser verificado.
	 * @return bool
	 */
	static public function isValid($valor)
	{
		return is_numeric($valor);
	}
	
	/**
	 * Inclui uma máscara em valores vindos do banco.
	 *
	 * Troca separador de decimal quando aplicável e
	 * inclui separador de milhar.
	 *
	 * O retorno deste método terá sempre duas casas decimais.
	 *
	 * IMPORTANTE: Os valores formatados por este método
	 * são apenas ilustrativos para que apareçam na tela,
	 * NUNCA usar para cálculos.
	 *
	 * @param mixed  $valor Valor monetário vindo do banco.
	 * @param string $format Formato desejado para o retorno(R$, U$, ou €$).
	 *
	 * @return string
	 */
	static public function Mask($valor, $format = self::REAL)
	{
		setlocale(LC_MONETARY, 'en_US');
		$valor = money_format('%.2n', $valor);
		return Util_Format_Number::toMoney($valor, $format);
	}
	
	/**
	 * Retira a máscara de valores vindos da tela.
	 *
	 * Retira separadores de milhar e troca separador
	 * de decimal quando aplicável.
	 *
	 * IMPORTANTE: Os valores retornados por este método
	 * ESTÃO aptos para cálculos, desde que CONVERTIDOS
	 * para FLOAT com "floatval()" ou "(float)".
	 *
	 * @param string $valor   Valor a ter sua máscara retirada.
	 * @param int    $decimal Número de casas decimais desejado.
	 * @param string $format  Formato("R$" ou "U$") em que o número está.
	 *
	 * @return mixed
	 */
	static public function UnMask($valor, $decimal = 2, $format = self::REAL)
	{
		switch($format) {
			case self::REAL:
			case self::EURO:
				$valor = str_replace('.', '' , $valor);
				$valor = str_replace(',', '.', $valor);
				return number_format($valor, $decimal, '.', '');
			break;
			case self::DOLAR:
				$valor = str_replace(',', '' , $valor);
				return number_format($valor, $decimal, '.', '');
			break;
			default:
				return false;
			break;
		}
	}
}
