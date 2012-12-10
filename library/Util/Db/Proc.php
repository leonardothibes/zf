<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Db
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Proc.php 21/11/2011 09:22:23 leonardo $
 */

/**
 * @see Util_Db_Abstract
 */
require_once 'Util/Db/Abstract.php';

/**
 * Classe front-end de procedures.
 *
 * @category Library
 * @package Util
 * @subpackage Db
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Db_Proc extends Util_Db_Abstract
{
	/**
	 * Flag que ativa o auto decode de saída.
	 * @var bool
	 */
	protected $_autoCharsetDecodeEnabled = false;
	
	/**
	 * Flag que ativa o auto encode de entrada.
	 * @var bool
	 */
	protected $_autoCharsetEncodeEnabled = false;
	
	/**
	 * Flag que ativa a auto conversão para XML.
	 * @var bool
	 */
	protected $_autoXmlEncodeEnabled = false;
	
	/**
	 * Executa uma procedure no banco de dados.
	 *
	 * @param string $proc   Nome da procedure.
	 * @param array  $params Parâmetros da procedure.
	 *
	 * @return mixed Retorno da procedure.
	 */
	public function __call($proc, $params = array())
	{
		try {
			$params = $this->_autoCharsetEncodeEnabled ? $this->charsetEncode($params) : $params;
			$sql    = $this->_sql($proc, $params);
			$result = $this->_execute($sql, $params);
			$result = $this->_autoCharsetDecodeEnabled ? $this->charsetDecode($result) : $result;
			$result = $this->_autoXmlEncodeEnabled     ? $this->toXml($result)         : $result;
			return $result;
		} catch(Exception $e) {
			$this->_throw($e);
		}
	}
	
	/**
	 * Ativa ou desativa o auto decode de saída.
	 *
	 * @param bool $flag
	 * @return Util_Db_Interface
	 */
	public function setAutoCharsetDecode($flag = true)
	{
		$this->_autoCharsetDecodeEnabled = (bool)$flag;
		return $this;
	}
	
	/**
	 * Ativa ou desativa o auto encode de entrada.
	 *
	 * @param bool $flag
	 * @return Util_Db_Interface
	 */
	public function setAutoCharsetEncode($flag = true)
	{
		$this->_autoCharsetEncodeEnabled = (bool)$flag;
		return $this;
	}
	
	/**
	 * Ativa ou desativa a auto conversão para XML.
	 *
	 * @param bool $flag
	 * @return Util_Db_Interface
	 */
	public function setAutoXmlEncode($flag = true)
	{
		$this->_autoXmlEncodeEnabled = (bool)$flag;
		return $this;
	}
	
	/**
	 * Monta a query a ser executada.
	 *
	 * @param string $proc   Nome da procedure.
	 * @param array  $params Parâmetros da procedure.
	 *
	 * @return string
	 */
	private function _sql($proc, $params)
	{
		$params = Util_Format_Array::toParamList($params);
		return sprintf('EXECUTE %s %s', $proc, $params);
	}
	
	/**
	 * Executa uma procedure.
	 *
	 * @param string $sql    Query SQL.
	 * @param array  $params Parâmetros.
	 *
	 * @return array
	 */
	private function _execute($sql, $params)
	{
		if($this->_db instanceof Zend_Db_Adapter_Abstract) {
			return $this->_db->query($sql, $params)->fetchAll();
		}
		return null;
	}
}
