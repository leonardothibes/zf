<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Db
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Table.php 21/11/2011 09:27:03 leonardo $
 */

/**
 * @see Util_Db_Abstract
 */
require_once 'Util/Db/Abstract.php';

/**
 * Classe front-end de tabelas.
 *
 * @category Library
 * @package Util
 * @subpackage Db
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Db_Table extends Util_Db_Abstract
{
	/**
	 * Mapeia uma tabela de banco de dados em objeto.
	 *
	 * @param string $name   Nome da tabela.
	 * @param string $schema Esquema onde a tabela está contido.
	 *
	 * @return void
	 */
	public function __construct($name, $schema = null)
	{
		
	}
}
