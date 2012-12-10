<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Library
 * @package Util
 * @subpackage Form
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: Abstract.php 15/10/2010 14:47:10 leonardo $
 */

/**
 * @see Smarty
 */
@require_once 'Smarty/Smarty.class.php';

/**
 * @see HTML_QuickForm
 */
require_once 'HTML/QuickForm.php';

/**
 * Abstração do HTML_QuickForm do PEAR.
 *
 * @category Library
 * @package Util
 * @subpackage Form
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Form_Abstract extends HTML_QuickForm
{
	/**
	 * Conteúdo HTML a ser agregado em campos de preenchimento obrigatório.
	 * @var string
	 */
	protected $_requiredTemplate = '{if $required} <span style="color:#FF0000;font-size:12px">*</span>{/if} {$label}';
	
	/**
	 * Conteúdo HTML a ser agregado em campos com erro após o POST.
	 * @var string
	 */
	protected $_errorTemplate = '{$html} {if $error} <br /><span style="color:#FF0000;font-size:12px">{$error}</span> {/if}';
	
	/**
	 * Construtor do formulário.
	 *
	 * @param string $name   Nome e ID que o formulário terá no HTML(opcional).
	 * @param string $action Action do fomulário(opcional).
	 * @param string $method Método de submissão do fomulário(opcional).
	 * @param string $target Target do formulário(opcional).
	 */
	public function __construct($name = 'form', $action = '', $method = 'post', $target = '')
	{
		if(!strlen($action)) {
			$request = new Zend_Controller_Request_Http();
			$action  = $request->getRequestUri();
		}
		
		parent::__construct($name, $method, $action, $target);
	}
	
	/**
	 * Configura o required template para os campos de preenchimento obrigatório.
	 *
	 * @param string $template Em branco deixa nulo.
	 * @return HTML_QuickForm
	 */
	public function setRequiredTemplate($template = null)
	{
		$template = strlen($template) ? (string)$template : '{$label}';
		$this->_requiredTemplate = (string)$template;
		return $this;
	}
	
	/**
	 * Converte o formulário em um array.
	 * @return array
	 */
	public function toArray($collectHidden = false)
	{
		$renderer = new HTML_QuickForm_Renderer_ArraySmarty(new Smarty());
		$renderer->setRequiredTemplate($this->_requiredTemplate);
		$renderer->setErrorTemplate($this->_errorTemplate);
		$this->accept($renderer);
		return $renderer->toArray();
	}
	
	/**
	 * Renderiza o formulário como um objeto SPL.
	 * @return object
	 */
	public function toObject()
	{
		$rendered = $this->toArray();
		$elements = new stdClass();
		$elements->frozen       = $rendered['frozen'];
		$elements->javascript   = $rendered['javascript'];
		$elements->attributes   = $rendered['attributes'];
		$elements->requirednote = $rendered['requirednote'];
		$elements->hidden       = $rendered['hidden'];
		$elements->errors       = $rendered['errors'];
		
		unset(
			$rendered['frozen'], $rendered['javascript'], $rendered['attributes'],
			$rendered['requirednote'], $rendered['hidden'], $rendered['errors']
		);
		
		foreach($rendered as $name => $element) {
			if(isset($element['name']) and isset($element['type'])) {
				$elements->{$element['name']} = Util_Format_Array::toObject($element);
			} else {
				$radios = new stdClass();
				foreach($element as $subname => $subelement) {
					$radios->{$subname} = Util_Format_Array::toObject($subelement);
				}
				$elements->{$name} = $radios;
			}
		}
		
		return $elements;
	}
	
	/**
	 * Renderiza o formulário como HTML.
	 */
	public function __toString()
	{
		return $this->toHtml();
	}
}
