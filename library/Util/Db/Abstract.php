<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Db
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Abstract.php 21/11/2011 09:20:01 leonardo $
 */

/**
 * @see Util_Db_Interface
 */
require_once 'Util/Db/Interface.php';

/**
 * @category Library
 * @package Util
 * @subpackage Db
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
abstract class Util_Db_Abstract implements Util_Db_Interface
{
	/**
	 * Objeto de conexão com o banco de dados.
	 * @var Zend_Db_Adapter_Abstract
	 */
	protected $_db = null;
	
	/**
	 * Charset de entrada no banco.
	 * @var string
	 */
	protected $_charsetInput = null;
	
	/**
	 * Charset de saída do banco.
	 * @var string
	 */
	protected $_charsetOutput = null;
	
	/**
	 * Conecta ao banco de dados.
	 *
	 * @param Zend_Db_Adapter_Abstract $db     Objeto de conexão(opcional).
	 * @param strind                   $input  Charset de entrada no banco.
	 * @param strind                   $output Charset de saída do banco.
	 *
	 * @return void
	 */
	public function __construct(Zend_Db_Adapter_Abstract $db = null, $input = null, $output = null)
	{
		try {
			if(Zend_Registry::isRegistered('db')) {
				//Conectando ao banco.
				$this->_db = is_null($db) ? Zend_Registry::get('db') : $db;
				
				//Configurando charset de entrada no banco.
				$this->_charsetInput = (string)(strlen($input) ? $input : 'cp850');
				
				//Configurando o charset de saída do banco.
				$this->_charsetOutput = (string)(strlen($output) ? $output : 'utf-8');
				
				//Configurando o ambiente.
				$this->_initEnv();
			}
		} catch(Excetion $e) {
			$this->_throw($e);
		}
	}
	
	/**
	 * Configuração o ambiente no banco.
	 * @return Util_Db_Interface
	 */
	private function _initEnv()
	{
		if($this->_db instanceof Zend_Db_Adapter_Pdo_Mssql) {
			$sql  = "SET ANSI_NULLS ON;";
			$sql .= "SET QUOTED_IDENTIFIER ON;";
			$this->_db->query($sql);
		}
	}
	
	/**
	 * Configura o charset de input.
	 *
	 * @param string $charset
	 * @return Util_Db_Interface
	 */
	public function setCharsetInput($charset)
	{
		$this->_charsetInput = (string)$charset;
		return $this;
	}
	
	/**
	 * Recupera o charset de input usado no momento.
	 * @return string
	 */
	public function getCharsetInput()
	{
		return (string)$this->_charsetInput;
	}
	
	/**
	 * Configura o charset de output.
	 *
	 * @param string $charset
	 * @return Util_Db_Interface
	 */
	public function setCharsetOutput($charset)
	{
		$this->_charsetOutput = (string)$charset;
		return $this;
	}
	
	/**
	 * Recupera o charset de output usado no momento.
	 * @return string
	 */
	public function getCharsetOutput()
	{
		return (string)$this->_charsetOutput;
	}
	
	/**
	 * Converte o charset de dados que irão para o banco.
	 *
	 * @param array $input
	 * @return array
	 */
	public function charsetEncode(array $input = array())
	{
		return array_map(array($this, '_iconvInput'), $input);
	}
	
	/**
	 * Efetua uma conversão de caracteres para input.
	 *
	 * @param array|string $output
	 * @return array|string
	 */
	private function _iconvInput($input = null)
	{
		if(is_array($input)) {
			return $this->charsetEncode($input);
		} else {
			return (string)iconv($this->_charsetOutput, $this->_charsetInput, $input);
		}
	}
	
	/**
	 * Converte o charset de dados que vem do banco.
	 *
	 * @param array $output
	 * @return array
	 */
	public function charsetDecode(array $output = array())
	{
		return array_map(array($this, '_iconvOutput'), $output);
	}
	
	/**
	 * Efetua uma conversão de caracteres para input.
	 *
	 * @param array|string $output
	 * @return array|string
	 */
	private function _iconvOutput($output = null)
	{
		if(is_array($output)) {
			return $this->charsetDecode($output);
		} else {
			return (string)iconv($this->_charsetInput, $this->_charsetOutput, $output);
		}
	}
	
	/**
	 * Converte um retorno do banco para XML.
	 *
	 * @param array $output Retorno do banco.
	 * @return string
	 */
	public function toXml(array $output = array())
	{
		return Util_Format_Array::toXml($output);
	}
	
	/**
	 * Lança uma exceção.
	 *
	 * @param Exception $e
	 * @return void
	 */
	protected function _throw(Exception $e)
	{
		require_once 'Util/Db/Exception.php';
		throw new Util_Db_Exception($e->getMessage(), $e->getCode());
	}
}
