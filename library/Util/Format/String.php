<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: String.php 20/10/2010 12:48:51 leonardo $
 */

/**
 * @see Util_Format_Abstract
 */
require_once 'Util/Format/Abstract.php';

/**
 * Rotinas para tratamento de string.
 *
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Format_String extends Util_Format_Abstract
{
	/**
	 * Testa se é uma string válida.
	 *
	 * @param mixed $data Dado a ser verificado.
	 * @return bool
	 */
	static public function isValid($data = null)
	{
		return
		(
			is_string($data)
			and !is_numeric($data)
			and !is_object($data)
			and !is_array($data)
			and strlen($data) > 0
		);
	}
	
	/**
	 * Limpa todo conteúdo inesperado para uma string válida.
	 *
	 * Todas as tags HTML são retiradas por default, a menos
	 * que se especifique o contrário ou excessões a regra.
	 *
	 * Comentários de SQL començando com "--" também serão
	 * retirados.
	 *
	 * Se após toda a filtragem ainda assim houverem caracteres
	 * estranhos, então estes serão escapados com contrabarras(\);
	 *
	 * @param mixed  $data String a ser limpa.
	 * @param string $tags Tags html permitidas("*" permite todas).
	 *
	 * @return false|string
	 */
	static public function Sanitize($data, $tags = '')
	{
		$data = (string)$data;
		if(strlen($tags)) {
			if($tags == '*') {
				$data = str_replace('--', '', $data);
				$data = addslashes($data);
			} else {
				$data = str_replace('--', '', $data);
				$data = addslashes($data);
				$data = strip_tags($data, $tags);
			}
			return $data;
		}
		
		$data = strip_tags($data, $tags);
		$data = filter_var($data, FILTER_SANITIZE_STRING);
		$data = str_replace('--', '', $data);
		$data = addslashes($data);
		
		return $data;
	}
	
	/**
	 * Formata uma string para ir ao banco de dados.
	 *
	 * @param string $string
	 * @return string
	 */
	static public function Encode($string)
	{
		return (string)iconv('utf-8', 'cp850', $string);
	}
	
	/**
	 * Formata uma string vinda da banco de dados.
	 *
	 * @param string $string
	 * @return string
	 */
	static public function Decode($string)
	{
		return (string)iconv('cp850', 'utf-8', $string);
	}
	
	/**
	 * Concatena strings com separador.
	 *
	 * @param string $str Variável de destino da concatenação.
	 * @param string $value Conteúdo a ser concatenado na variável $str.
	 * @param string $sep Separador da concatenação.
	 */
	static public function AddStr(& $str, $value, $sep= ',')
	{
		if(strlen($str)) {
			$str .= " $sep ";
		}
		$str .= " $value ";
	}
	
	/**
	 * Adiciona aspas a uma string.
	 *
	 * @param string $string String a ter aspas adicionadas.
	 * @return string
	 */
	static public function AddQuotes($string)
	{
		return "'" . (string)$string . "'";
	}
	
	/**
	 * Adiciona uma barra no início de uma string.
	 *
	 * Caso a string já possua a barra então a
	 * string fica inalterada.
	 *
	 * @param string $string String a ser formatada.
	 * @return string
	 */
	static public function FirstSlash($string)
	{
		return (string)substr($string, 0, 1) != '/' ? '/' . $string : $string;
	}
	
	/**
	 * Adiciona uma barra ao final de uma string.
	 *
	 * Caso a string já possua a barra então a
	 * string fica inalterada.
	 *
	 * @param string $string String a ser formatada.
	 * @return string
	 */
	static public function LastSlash($string)
	{
		return (string)substr($string, -1) != '/' ? $string . '/' : $string;
	}
	
	/**
	 * Trunca uma string em um determinado tamanho.
	 *
	 * @param string $string String a ser truncada.
	 * @param int    $limit  Limite de caracteres que a string deve ter.
	 * @param string $char   Caracter(es) de substituíção.
	 *
	 * @return string
	 */
	static public function Truncate($string = null, $limit = 32, $char = '&hellip;')
	{
		if(strlen($string) < (int)$limit) {
			return $string;
		}
		
		$output = substr($string, 0, (int)$limit - 1);
		return $output . $char;
	}
	
	/**
	 * Retira espaços e converte para minúsculas uma string.
	 *
	 * @param string $string String a ser formatada.
	 * @return string
	 */
	static public function LowerTrim($string)
	{
		return (string)strtolower(trim($string));
	}
	
	/**
	 * Retira espaços e converte para maiúsculas uma string.
	 *
	 * @param string $string String a ser formatada.
	 * @return string
	 */
	static public function UpperTrim($string)
	{
		return (string)strtoupper(trim($string));
	}
	
	/**
	 * Deixa a primeira letra de uma string maiúscula.
	 *
	 * @param  string $string String a ser convertida.
	 * @return string
	 */
	static public function Capitalize($string = null)
	{
		return ucfirst(strtolower((string)$string));
	}
	
	/**
	 * Substitui qualquer quantidade de espaços numa string por apenas um espaço.
	 *
	 * @param string $string String a ser formatada.
	 * @return string
	 */
	static public function OneSpaceOnly($string)
	{
		return (string)preg_replace('/\s\s+/', ' ', trim($string));
	}
	
	/**
	 * Remove espaços e substitui pelo caractere especificado.
	 *
	 * @param string $string String a ser formatada.
	 * @param string $char Caracter que irá substituir o espaço.
	 *
	 * @return string.
	 */
	static public function StripSpaces($string, $char = '_')
	{
		return (string)str_replace(' ', $char, trim($string));
	}
	
	/**
	 * Remove quebras de linha em uma string.
	 *
	 * @param string $string String a ser formatada.
	 *
	 * @return string
	 */
	static public function StripBreak($string)
	{
		return preg_replace('/\n/', '', $string);
	}
	
	/**
	 * Formata um nome de classe no formato do Zend_Framework.
	 *
	 * @param string $name Nome a ser formatado.
	 * @return string
	 */
	static public function ZendName($name)
	{
		if(strpos($name, '_')) {
			$name = @explode('_', $name);
			$name = array_map(array('self', 'Capitalize'), $name);
			$name = @implode('_', $name);
		}
		return $name;
	}
	
	/**
     * Remove de acentuação e cedilhas de uma string.
     *
     * @param string $string String a ser formatada.
     * @return string String sem acentos.
     */
    static public function StripAccents($string)
    {
		return strtr($string, array(
			
			/** Bloco do A **/
			'á' => 'a',
			'Á' => 'A',
			'à' => 'a',
			'À' => 'A',
			'â' => 'a',
			'Â' => 'A',
			'ã' => 'a',
			'Ã' => 'A',
			'ä' => 'a',
			'Ä' => 'A',
			/** Bloco do A **/
			
			/** Bloco do E **/
			'é' => 'e',
			'É' => 'E',
			'è' => 'e',
			'È' => 'E',
			'ê' => 'e',
			'Ê' => 'E',
			'ë' => 'e',
			'Ë' => 'E',
			/** Bloco do E **/
			
			/** Bloco do I **/
			'í' => 'i',
			'Í' => 'I',
			'ì' => 'i',
			'Ì' => 'I',
			'î' => 'i',
			'Î' => 'I',
			'ĩ' => 'i',
			'Ĩ' => 'I',
			'ï' => 'i',
			'Ï' => 'I',
			/** Bloco do I **/
			
			/** Bloco do O **/
			'ó' => 'o',
			'Ó' => 'O',
			'ò' => 'o',
			'Ò' => 'O',
			'ô' => 'o',
			'Ô' => 'O',
			'õ' => 'o',
			'Õ' => 'O',
			'ö' => 'o',
			'Ö' => 'O',
			/** Bloco do O **/
			
			/** Bloco do U **/
			'ú' => 'u',
			'Ú' => 'U',
			'ù' => 'u',
			'Ù' => 'U',
			'û' => 'u',
			'Û' => 'U',
			'ũ' => 'u',
			'Ũ' => 'U',
			'ü' => 'u',
			'Ü' => 'U',
			/** Bloco do U **/
			
			/** Bloco do Ç **/
			'ç' => 'c',
			'Ç' => 'C'
			/** Bloco do Ç **/
		));
    }
}
