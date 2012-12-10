<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: FiltroAno.php 16/06/2011 15:14:23 leonardo $
 */

/**
 * Helper para filtro de anos.
 *
 * @category Library
 * @package Util
 * @subpackage View
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_View_Helper_FiltroAno extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * Monta na tela um combo com a quantidade de anos especificada.
	 *
	 * Quando se altera um valor no combo é feito uma requisição POST na url especificada.
	 * Ao não especificar nenhuma url então o POST é feito na url da página atual.
	 *
	 * @param int    $qtde     Quantidade de anos que o fltro terá a partir do atual.
	 * @param string $selected Ano que vem selecionado no combo.
	 * @param string $post     Url onde será feito o POST(opcional).
	 *
	 * @return string HTML do box.
	 */
	public function FiltroAno($qtde = 5, $selected = null, $post = null)
	{
		if(!strlen($post)) {
			$request = new Zend_Controller_Request_Http();
			$post    = $request->getRequestUri();
		}
		
		$post = Util_Format_String::Sanitize($post);
		$id   = sprintf('form-filtro-ano-%s', md5(rand(1,100)));
		$opts = null;
		$html = '<form id=":ID" action=":POST" method="post">
			<select name="ano" onchange="document.getElementById(\':ID\').submit()">
				:OPTS
			</select>
		</form>';
		
		$anos = Util_Format_Date::YearList((int)$qtde);
		foreach($anos as $ano) {
			$sel   = ($ano == $selected) ? ' selected="selected"' : null;
			$opts .= sprintf('<option value="%d"%s>%d</option>%s', $ano, $sel, $ano, "\n");
		}
		
		return strtr($html, array(
			':ID'   => $id,
			':POST' => $post,
			':OPTS' => $opts
		));
	}
}
