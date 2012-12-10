<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Xml
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Interface.php 22/12/2011 10:14:43 leonardo $
 */

/**
 * @category Library
 * @package Util
 * @subpackage Xml
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
interface Util_Xml_Interface
{
	/**
	 * Construtor.
	 *
	 * @param string $xml Caminho para o XML.
	 * @param int $limit  Limite de registros por página.
	 */
	public function __construct($xml = null, $limit = self::DEFAULT_LIMIT);
	
	/**
	 * Seta o caminho do XML.
	 *
	 * @param string $path
	 * @return Video_Interface
	 */
	public function setPath($path);
	
	/**
	 * Recupera o caminho do XML.
	 * @return string
	 */
	public function getPath();
	
	/**
	 * Seta o limite de registros por página.
	 *
	 * @param int $limit Em branco volta ao valor default.
	 * @return Video_Interface
	 */
	public function setLimit($limit = self::DEFAULT_LIMIT);
	
	/**
	 * Recupera o limite de registros por página.
	 * @return int
	 */
	public function getLimit();
	
	/**
	 * Recupera o objeto XML.
	 * @return SimpleXMLElement
	 */
	public function getXmlAsObject();
	
	/**
	 * Recupera a string do XML.
	 *
	 * @param bool $stripSpacesAndBreaks Se ativado então suprime espaços e quebras de linha.
	 * @return string
	 */
	public function getXmlAsString($stripSpacesAndBreaks = false);
	
	/**
	 * Calcula um MD5 do arquivo XML.
	 * @return string
	 */
	public function md5();
	
	/**
	 * Consulta um vídeo.
	 *
	 * @param string $id    ID do vídeo.
	 * @param string $node  Nome do nó XML para a consulta Xpath.
	 * @param string $ident Nome do campo que será usado como identificador na consulta.
	 *
	 * @return array
	 */
	public function consulta($id, $node = 'video', $ident = 'id');
	
	/**
	 * Lista todos os vídeos.
	 *
	 * @param int    $pagina Página de registros.
	 * @param string $path   Caminho completo para a árvore de vídeos no XML.
	 * @param string $ident  Nome do campo que será usado como identificador único de registro.
	 *
	 * @return array
	 */
	public function lista($pagina = 1, $path = '/videos/video', $ident = 'id');
	
	/**
	 * Conta o total de vídeos cadastrados.
	 *
	 * @param string $path   Caminho completo para a árvore de vídeos no XML.
	 * @return int
	 */
	public function total($path = '/video/videos');
}
