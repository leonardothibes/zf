<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Array.php 20/10/2010 16:50:13 leonardo $
 */

/**
 * @see Util_Format_Abstract
 */
require_once 'Util/Format/Abstract.php';

/**
 * Rotinas para tratamento de array.
 *
 * @category Library
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Format_Array extends Util_Format_Abstract
{
	/**
	 * Testa se é um array válido.
	 *
	 * Array vazio não é considerado
	 * como válido para este método.
	 *
	 * @param array $data
	 * @return bool
	 */
	static public function isValid($data = null)
	{
		return (is_array($data) and count($data) > 0);
	}
	
	/**
	 * Filtra todo o conteúdo de um array associativo.
	 *
	 * O filtro é aplicado somente aos valores,
	 * não aos índices do array.
	 *
	 * O filtro só se aplica a arrays associativos
	 * de uma dimenção. Matrizes não devem ser passadas.
	 *
	 * @param mixed  $data   Array a ser limpo.
	 * @param string $filter Tipo de filtro a ser aplicado(i: integer, f: float, s: string com sanitize).
	 *
	 * @return array
	 * @throws Zend_Exception Em caso de array ou filtro inválidos.
	 */
	static public function Sanitize($data, $filter = 's')
	{
		//Testando se é um array.
		if(!self::isValid($data)) {
			require_once 'Util/Format/Exception.php';
			throw new Util_Format_Exception('Array inválido.', -1);
		}
		
		switch($filter) {
			case 's':
				//Filtrando como string.
				$data = array_map('Util_Format_String::Sanitize', $data);
			break;
			case 'i':
				//Filtrando como integer.
				$data = array_map('intval', $data);
			break;
			case 'f':
				//Filtrando como float.
				$data = array_map('floatval', $data);
			break;
			default:
				//Filtro inválido.
				require_once 'Util/Format/Exception.php';
				throw new Util_Format_Exception('Tipo de filtro inválido.', -2);
			break;
		}
		
		return $data;
	}
	
	/**
	 * Adiciona aspas em todas as posições de um array.
	 *
	 * @param array $array
	 * @return array
	 */
	static public function AddQuotes(array $array)
	{
		return array_map('Util_Format_String::AddQuotes', $array);
	}
	
	/**
	 * Transforma um array em uma lista de parâmetros com aspas.
	 *
	 * @param array $array
	 * @return string
	 */
	static public function toParamList(array $array)
	{
		return @implode(',', self::AddQuotes($array));
	}
	
	/**
	 * Converte um array numa string XML.
	 *
	 * @param array            $array Array a ser convertido.
	 * @param string           $root  Nome do nó raiz do XML(opcional).
	 * @param SimpleXMLElement $xml   Objeto para recursividade.
	 *
	 * @return string
	 */
	static public function toXml(array $array, $root = 'root', $xml = null)
	{
		if(is_null($xml)) {
			$root = sprintf('<%s />', $root);
			$xml  = new SimpleXmlElement($root);
		}
		
		foreach($array as $key => $value) {
			
			$key = is_numeric($key) ? 'row' : $key;
			$key = preg_replace('/[^a-z]/i', '', $key);
			
			if(is_array($value)) {
				$node = $xml->addChild($key);
				self::toXml($value, $root, $node);
			} else {
				$xml->addChild(strtolower($key), $value);
			}
		}
		
		return $xml->asXML();
	}
	
	/**
	 * Converte um array num objeto.
	 *
	 * @param array  $array  Array a ser convertido.
	 * @param string $object Tipo de objeto(opcional).
	 *
	 * @return object
	 */
	static public function toObject($array, $object = 'stdClass')
	{
		if(!is_array($array)) {
			return $array;
		}
		
		$obj = new $object();
		foreach($array as $key => $value) {
			$key = trim($key);
			$obj->{$key} = self::toObject($value);
		}
		
		return $obj;
	}
	
	/**
	 * Remove índices em branco de um array.
	 *
	 * @param array $array Array a ser formatado
	 * @return array
	 */
	static public function RemoveEmpty(array $array)
	{
		if(self::isValid($array)) {
			foreach($array as $idx => $value) {
				if(!strlen($value)) {
					unset($array[$idx]);
				}
			}
		}
		return $array;
	}
	
	/**
	 * Pesquisa uma string em um array.
	 *
	 * @param array  $array   Array que contém a lista.
	 * @param string $search  String a ser pesquisada.
	 * @param bool   $use_key Se ativado então concatena a chave do array.
	 * @param string $sep	  Separador para concatenar a chave.
	 *
	 * @return string Resultado obtido na pesquisa.
	 */
	static public function Search(array $array, $search, $use_key = true, $sep = '|')
	{
		$result = null;
		if(self::isValid($array)) {
			foreach($array as $key => $value) {
				if(strpos(strtolower($value), $search) !== false) {
					if($use_key) {
						$result .= $key . $sep . $value . "\n";
					} else {
						$result .= $value . "\n";
					}
				}
			}
		}
		return (string)$result;
	}
	
	/**
	 * Ordena um Array pela coluna especificada.
	 *
	 * @param array   $array   Array a ser ordenado.
	 * @param string  $column  Coluna a ser considerada na ordenação.
	 * @param boolean $reverse Flag que deixa o array ao contrário.
	 *
	 * @return array Array ordenado.
	 */
	static public function orderBy(array $array, $column, $reverse = false)
	{
		for($i = 0; $i < count($array) - 1; $i++) {
			for($j = 0; $j < count($array) - 1 - $i; $j++) {
				if($array[$j][$column] > $array[$j+1][$column]) {
					$tmp = $array[$j];
					$array[$j] = $array[$j+1];
					$array[$j+1] = $tmp;
				}
			}
		}
		return $reverse ? array_reverse($array) : $array;
	}
}
