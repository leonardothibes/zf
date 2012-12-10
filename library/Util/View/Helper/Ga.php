<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Ga.php 23/09/2010 16:34:03 leonardo $
 */

/**
 * Helper Google Analytics.
 *
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_View_Helper_Ga extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * URL para o JS do Google.
	 * @var string
	 */
	private $_ga = 'google-analytics.com/ga.js';
	
	/**
	 * Insere o JavaScript do Google Analytics na página.
	 *
	 * Por padrão a configuração do Google Analytics é obtida diretamente
	 * do arquivo "config.ini", embora seja possível forçar um ID.
	 *
	 * Para que seja possível obter as configurações diretamente do
	 * arquivo "config.ini" um índice de objeto "config->ga" deve
	 * ser registrado na Zend_Registry.
	 *
	 *
	 * @param int $id ID do Google Analytics[opcional].
	 * @return string JS do Google Analytics.
	 */
	public function Ga($id = null)
	{
		try {
			$config = Zend_Registry::get('config');
			if(!$config->ga->enable) {
				return null;
			}
			
			$tag = '
				<script type="text/javascript">
					var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
					document.write(unescape("%3Cscript src=\'" + gaJsHost + ":GA\' type=\'text/javascript\'%3E%3C/script%3E"));
				</script>
				<script type="text/javascript">
					try {
						var pageTracker = _gat._getTracker(":ID");
						pageTracker._trackPageview();
					} catch(err) {}
				</script>
			';
			
			$id = strlen($id) ? (string)$id : $config->ga->id;
			return strtr($tag, array(
				':GA' => $this->_ga,
				':ID' => $id
			));
		} catch(Zend_Exception $e) {
			return null;
		}
	}
}
