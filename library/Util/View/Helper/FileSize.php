<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: FileSize.php 01/10/2010 13:44:52 leonardo $
 */

/**
 * Helper File.
 *
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_View_Helper_FileSize extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * Retorna o tamanho de um arquivo já formatado para aparecer na tela.
	 *
	 * @param string $file  Caminho para o arquivo a partir da raiz do projeto.
	 * @param bool   $round Se ativado então faz o arredondamento.
	 *
	 * @return string Tamanho do arquivo formatado.
	 */
	public function FileSize($file = null, $round = false)
	{
		return Util_File::Size($file, $round);
	}
}
