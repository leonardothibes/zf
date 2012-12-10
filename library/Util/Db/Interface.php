<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Db
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Interface.php 21/11/2011 09:17:39 leonardo $
 */

/**
 * Interface padrão para os acessos a banco de dados.
 *
 * @category Library
 * @package Util
 * @subpackage Db
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
interface Util_Db_Interface
{
	/**
	 * Conecta ao banco de dados.
	 *
	 * @param Zend_Db_Adapter_Abstract $db     Objeto de conexão(opcional).
	 * @param strind                   $input  Charset de entrada no banco.
	 * @param strind                   $output Charset de saída do banco.
	 *
	 * @return void
	 */
	public function __construct(Zend_Db_Adapter_Abstract $db = null, $input = null, $output = null);
	
	/**
	 * Converte o charset de dados que irão para o banco.
	 *
	 * @param array $input
	 * @return array
	 */
	public function charsetEncode(array $input = array());
	
	/**
	 * Converte o charset de dados que vem do banco.
	 *
	 * @param array $output
	 * @return array
	 */
	public function charsetDecode(array $output = array());
	
	/**
	 * Converte um retorno do banco para XML.
	 *
	 * @param array $output Retorno do banco.
	 * @return string
	 */
	public function toXml(array $output = array());
}
