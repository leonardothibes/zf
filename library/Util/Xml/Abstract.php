<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Xml
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Abstract.php 22/12/2011 10:18:29 leonardo $
 */

/**
 * @see Util_Xml_Interface
 */
require_once 'Util/Xml/Interface.php';

/**
 * @category Library
 * @package Util
 * @subpackage Xml
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
abstract class Util_Xml_Abstract implements Util_Xml_Interface
{
	/**
	 * Caminho para o XML.
	 * @var string
	 */
	protected $_path = null;
	
	/**
	 * Objeto do XML.
	 * @var SimpleXMLElement
	 */
	protected $_xml = null;
	
	/**
	 * Limite de registros por página.
	 * @var int
	 */
	protected $_limit = 0;
	
	/**
	 * Limite de registros default.
	 * @var int
	 */
	const DEFAULT_LIMIT = 9;
	
	/**
	 * Construtor.
	 *
	 * @param string $xml   Caminho para o XML.
	 * @param int    $limit Limite de registros por página.
	 *
	 * @throws Util_Xml_Exception
	 * @return void
	 */
	public function __construct($xml = null, $limit = self::DEFAULT_LIMIT)
	{
		$this->setPath($xml);
		$this->setLimit($limit);
	}
	
	/**
	 * Seta o caminho do XML.
	 *
	 * @param string $path
	 * @return Util_Xml_Interface
	 * @throws Util_Xml_Exception
	 */
	public function setPath($path)
	{
		try {
			if(!file_exists($path) or !is_readable($path)) {
				$this->_throw(sprintf('O XML "%s" não foi localizado.', $path));
			}
			
			$this->_path = (string)$path;
			$this->_xml  = simplexml_load_file($this->_path);
			
			if(!$this->_xml instanceof SimpleXMLElement) {
				$this->_throw('O arquivo especificado não contém um XML válido.');
			}
			
			return $this;
		} catch(Exception $e) {
			$this->_throw($e->getMessage(), $e->getCode());
		}
	}
	
	/**
	 * Recupera o caminho do XML.
	 * @return string
	 */
	public function getPath()
	{
		return (string)$this->_path;
	}
	
	/**
	 * Seta o limite de registros por página.
	 *
	 * @param int $limit Em branco volta ao valor default.
	 * @return Util_Xml_Interface
	 */
	public function setLimit($limit = self::DEFAULT_LIMIT)
	{
		$this->_limit = (int)$limit;
		if($this->_limit < 1) {
			$this->_throw('O limite de registros não pode ser inferior a 1.');
		}
		return $this;
	}
	
	/**
	 * Recupera o limite de registros por página.
	 * @return int
	 */
	public function getLimit()
	{
		return (int)$this->_limit;
	}
	
	/**
	 * Recupera o objeto XML.
	 * @return SimpleXMLElement
	 */
	public function getXmlAsObject()
	{
		return $this->_xml;
	}
	
	/**
	 * Recupera a string do XML.
	 *
	 * @param bool $stripSpacesAndBreaks Se ativado então suprime espaços e quebras de linha.
	 * @return string
	 */
	public function getXmlAsString($stripSpacesAndBreaks = false)
	{
		return (string)($stripSpacesAndBreaks ?
			preg_replace('/\n\s+/', '', file_get_contents($this->_path)) :
			file_get_contents($this->_path)
		);
	}
	
	/**
	 * Calcula um MD5 do arquivo XML.
	 * @return string
	 */
	public function md5()
	{
		return (string)md5($this->getXmlAsString(true));
	}
	
	/**
	 * Consulta um vídeo.
	 *
	 * @param string $id    ID do vídeo.
	 * @param string $node  Nome do nó XML para a consulta Xpath.
	 * @param string $ident Nome do campo que será usado como identificador na consulta.
	 *
	 * @return array
	 */
	public function consulta($id, $node = 'video', $ident = 'id')
	{
		$xml = $this->_xml->xpath("//{$node}[@{$ident}=\"{$id}\"]");
		$rs  = array();
		
		foreach($xml[0] as $key => $value) {
			$rs[$ident]       = (string)$xml[0]->attributes()->id[0];
			$rs[(string)$key] = (string)$value;
		}
		
		return $rs;
	}
	
	/**
	 * Lista todos os vídeos.
	 *
	 * @param int    $pagina Página de registros.
	 * @param string $path   Caminho completo para a árvore de vídeos no XML.
	 * @param string $ident  Nome do campo que será usado como identificador único de registro.
	 *
	 * @return array
	 */
	public function lista($pagina = 1, $path = '/videos/video', $ident = 'id')
	{
		$xml = $this->_xml->xpath("{$path}");
		$rs  = array();
		
		foreach($xml as $id => $row) {
			foreach($row as $key => $value) {
				$rs[$id][$ident]       = (string)$xml[$id]->attributes()->id[0];
				$rs[$id][(string)$key] = (string)$value;
			}
		}
		
		$offset = --$pagina * $this->_limit;
		return array_slice($rs, $offset, $this->_limit);
	}
	
	/**
	 * Conta o total de vídeos cadastrados.
	 *
	 * @param string $node Nome do nó XML para a consulta Xpath.
	 * @return int
	 */
	public function total($node = 'video')
	{
		return $this->_xml->{$node}->count();
	}
	
	/**
	 * Lança uma exception.
	 *
	 * @param string $mesg Mensagem de erro.
	 * @param int    $code Código do erro.
	 */
	protected function _throw($mesg, $code = -1)
	{
		require_once 'Util/Xml/Exception.php';
		throw new Util_Xml_Exception($mesg);
	}
}
